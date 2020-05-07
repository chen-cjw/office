<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatPay extends Model
{


    protected $fillable = ['number','day','body','detail','out_trade_no','user_id','total_fee','status','paid_at'];
    // 支付随机数
    public function outTradeNo()
    {
        mt_srand((double)microtime() * 1000000);//用 seed 来给随机数发生器播种。
        $strand = str_pad(mt_rand(1, 99999),6,"0",STR_PAD_LEFT);
        return date('Ymd').$strand;
    }
}
