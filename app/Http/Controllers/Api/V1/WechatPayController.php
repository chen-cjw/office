<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\WechatPayRequest;
use App\Jobs\CloseWechatPay;
use App\Models\WechatPay;
use App\Transformers\WechatPayTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WechatPayController extends Controller
{
    public function __construct()
    {
        $this->app = app('wechat.payment');
    }
    //
    public function index()
    {
        $wechatPays = $this->user()->wechatPays()->orderBy('created_at','desc')->paginate();
        return $this->response->paginator($wechatPays,new WechatPayTransformer());
    }
    // 唤起支付---创建支付订单
    public function store($wechatPay,$request,$idDay,$isAddTime,$totalFee)
    {
//        $day = floor((strtotime($this->user()->team->close_time)-time())/86400);
//        $year = bcmul(bcmul(bcdiv(config('app.default_personal_price'),365,8),$day),$request->number);// 默认一年
        // bcdiv — 相除||bcmul — 乘法
        $wechatPay = new WechatPay([
            'out_trade_no' => $wechatPay->findAvailableNo(),
            'total_fee' => $totalFee,//bcmul($year,$request->day),
            'number' => $request->number,
            'day' => $idDay,
            'is_add_time' => $isAddTime, // 添加时间
        ]);
        // 现在要做一个日志记录以前有几个人，此方法已记录人数和收费
        $wechatPay->user()->associate($this->user());
        $wechatPay->save();
        $this->dispatch(new CloseWechatPay($wechatPay, config('app.close_time')));
        return $wechatPay;
    }

    public function storeAdd(WechatPay $wechatPay,WechatPayRequest $request)
    {
        if($request->day != '0') {
            $totalFee = bcmul(bcmul(config('app.default_personal_price'),$request->number),$request->day);
            return $this->store($wechatPay, $request, $request->day, true,$totalFee); // 延长使用时间
        }
        $day = floor((strtotime($this->user()->team->close_time)-time())/86400); // 天数
        // 增加的人数到期时间不足一年的，以单价除以365天乘以剩余未到期天数进行计算
        $totalFee = bcmul(bcmul(bcdiv(config('app.default_personal_price'),365,8),$day),$request->number);//
        return $this->store($wechatPay, $request, 0, false,$totalFee); // 增加人数
    }
    /**
     * 唤起支付操作，
     * JSAPI--JSAPI支付（或小程序支付）、NATIVE--Native支付、APP--app支付，MWEB--H5支付，
     **/
    public function payByWechat($id) {
        // 校验权限
        $wechatPay = $this->user()->wechatPays()->where('id',$id)->firstOrFail();
        // bcsub — 减法
        if (bcsub(strtotime($wechatPay->created_at),time()) > 3600) {
            throw new ResourceException('此订单已过期，请删除此订单重新付款！');
        }
        // 校验订单状态
        if ($wechatPay->paid_at || $wechatPay->closed) {
            throw new ResourceException('订单状态不正确');
        }

        $result = $this->app->order->unify([
            'body' => '支付会员版订单：'.$wechatPay->out_trade_no,
            'out_trade_no' => $wechatPay->out_trade_no,
            'total_fee' => 1,//$wechatPay->total_fee * 100,
            //'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
            'notify_url' => config('wechat.payment.default.notify_url'), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid' => auth('api')->user()->ml_openid,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
        ]);
        $jssdk = $this->app->jssdk;
        $json = $jssdk->bridgeConfig($result['prepay_id'],false);
        return $json;
    }
    // 创建订单 -- 通知
    public function handlePaidNotify()
    {
        Log::info('进入');

        $response = $this->app->handlePaidNotify(function($message, $fail){
            Log::info('微信支付订单号');
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = WechatPay::where('out_trade_no',$message['out_trade_no'])->first();

            if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
                Log::info('告诉微信，我已经处理完了，订单没找到，别再通知我了');
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            ///////////// todo <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            Log::info('建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付');

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                Log::info('表示通信状态，不代表支付状态');

                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    Log::info('用户是否支付成功');
                    
                    $order->status = 'paid';
                    $order->paid_at = Carbon::now(); // 更新支付时间为当前时间
                    $order->payment_no = $message['transaction_id']; // 支付平台订单号
                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    Log::info('用户支付失败');
                    $order->status = 'paid_fail';
                }
            } else {
                Log::info('通信失败，请稍后再通知我');
                return $fail('通信失败，请稍后再通知我');
            }
            $order->save(); // 保存订单
            if($order->day == 0) {
                // 未添加成功的ID
                Log::info('未添加成功的ID:'.$order->id);
                $order->user->team()->increment('number_count',$order->number);
            }else {
                Log::info('未添加成功的ID:'.$order->id);
                $team = $order->user->team->first();
                $team->update(['close_time'=>date('Y-m-d', strtotime('+'.($order->day*365).' day', strtotime($team->close_time)))]);
            }
            $order->id;
            return true; // 返回处理完成
        });
        return $response;
    }
    // todo 接收通知（主动去查/被动接收）
    // 根据商户订单号查询(此单是否支付)
    public function queryByOutTradeNumber()
    {
        return $this->app->order->queryByOutTradeNumber("商户系统内部的订单号（out_trade_no）");
    }
    // 支付两小时就关闭此单
    public function close()
    {
        return $this->app->order->close('商户系统内部的订单号（out_trade_no）');
    }
}
