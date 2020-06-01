<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\WechatPay;
use Illuminate\Http\Request;

class WechatPayController extends Controller
{
    public function __construct()
    {
        $this->app = app('wechat.payment');
    }
    //
    public function index()
    {

    }
    // 唤起支付---创建支付订单
    public function store(WechatPay $wechatPay)
    {
        $notifyUrl = route('api.wechat_pay.handle_paid_notifies');
        $body = '购买会员版';
        dd($body);
        // JSAPI--JSAPI支付（或小程序支付）、NATIVE--Native支付、APP--app支付，MWEB--H5支付，
        $result = $this->unify($body,$wechatPay->findAvailableNo(),$totalFee=0.01,'JSAPI',$this->user->ml_openid,$notifyUrl);
        return $result;
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
    
    // 下单==提交一份到微信里面去了，我本地也可以存一份
    public function unify($body,$outTradeNo,$totalFee,$tradeType,$openid,$notifyUrl)
    {
        $data = [
            'body' => $body,//'购买会员版',// 描述 || detail 更具体的描述
            'out_trade_no' => $outTradeNo, // 随机数商户订单号
            'total_fee' => $totalFee * 100, // 计算单位是分
            'notify_url' => $notifyUrl, // (通知/回调地址) 告诉微信服务求，订单的状态变化，请通过这个地址告诉我。我们服务器地址
            'trade_type' => $tradeType, // 请对应换成你的支付方式对应的值类型 JSAPI
            'openid' => $openid, // $this->user->ml_openid
        ];
        ///$app->order->unify($data); // todo 这里要看一下 ，过期报错|一定要看错误的情况
        $data['number'] =  \request()->number;
        $data['day'] =  \request()->day;
        return WechatPay::create($data);
    }
    // 创建订单 -- 通知
    public function handlePaidNotify()
    {
        $response = $this->app->handlePaidNotify(function($message, $fail){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = WechatPay::where('out_trade_no',$message['out_trade_no'])->firstOrFail();

            if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            ///////////// todo <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
//                if ($message['result_code'] === 'SUCCESS') {
                    $order->paid_at = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                    $order->status = 'paid';

                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->status = 'paid_fail';
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }
}
