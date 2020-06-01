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

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }
}
