<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatPay extends Model
{

    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_APPLIED = 'applied';
    const REFUND_STATUS_PROCESSING = 'processing';
    const REFUND_STATUS_SUCCESS = 'success';
    const REFUND_STATUS_FAILED = 'failed';

    public static $refundStatusMap = [
        self::REFUND_STATUS_PENDING    => '未退款',
        self::REFUND_STATUS_APPLIED    => '已申请退款',
        self::REFUND_STATUS_PROCESSING => '退款中',
        self::REFUND_STATUS_SUCCESS    => '退款成功',
        self::REFUND_STATUS_FAILED     => '退款失败',
    ];
    protected $fillable = ['number','day','body','detail','out_trade_no','user_id','total_fee','status','paid_at','payment_no'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
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
            if (!static::query()->where('out_trade_no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }
}
