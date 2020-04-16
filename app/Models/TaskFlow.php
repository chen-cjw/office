<?php

namespace App\Models;

class TaskFlow extends ImageUpload
{
    // 开始(start)|进行中(pending)|完成(complete)|逾期(expired)
    const REFUND_STATUS = 'start';
    const REFUND_PENDING = 'pending';
    const REFUND_STOP = 'stop';
    const REFUND_EXPIRED = 'complete';

    public static $status = [
        self::REFUND_STATUS => '开始',
        self::REFUND_PENDING => '进行中',
        self::REFUND_STOP => '完成',
        self::REFUND_EXPIRED => '逾期',
    ];

    protected $fillable = [
        'step_name','status'
    ];

    public function taskFlowCollection()
    {
        return $this->belongsTo(TaskFlowCollection::class);
    }

}
