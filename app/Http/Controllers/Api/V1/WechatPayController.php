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
    // 创建支付订单
    public function store(WechatPay $wechatPay)
    {
        $result = $this->unify($this->app,$wechatPay->outTradeNo(),$totalFee=88,'JSAPI',$this->user->ml_openid);

    }
    // 根据商户订单号查询
    public function queryByOutTradeNumber()
    {
        return $this->app->order->queryByOutTradeNumber("商户系统内部的订单号（out_trade_no）");

    }
    
    // queryByTransactionId
    public function queryByTransactionId()
    {
        return $this->app->order->queryByTransactionId("微信订单号（transaction_id）");
    }
    // 
    public function unify($app,$outTradeNo,$totalFee,$tradeType,$openid)
    {
        return $app->order->unify([
            'body' => '购买会员版',
            'out_trade_no' => $outTradeNo, //
            'total_fee' => $totalFee, // 计算单位是分
            'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'trade_type' => $tradeType, // 请对应换成你的支付方式对应的值类型 JSAPI
            'openid' => $openid, //$this->user->ml_openid
        ]);
    }
    
    // 通知
    public function handlePaidNotify()
    {
        
    }
}
