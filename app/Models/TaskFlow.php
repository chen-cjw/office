<?php

namespace App\Models;

class TaskFlow extends ImageUpload
{
    // 开始(start)|进行中(pending)|完成(complete)|逾期(expired)
    const REFUND_STATUS = 'start';
    const REFUND_PENDING = 'pending';
    const REFUND_END = 'end';
    const REFUND_EXPIRED = 'complete';
    // 开始(start)|进行中(pending)|完成(end)|逾期(expired)
    public static $status = [
        self::REFUND_STATUS => '开始',
        self::REFUND_PENDING => '进行中',
        self::REFUND_END => '完成',
        self::REFUND_EXPIRED => '逾期',
    ];

    protected $fillable = [
        'step_name','status','user_id','task_flow_collection_id'
    ];

    public function taskFlowCollection()
    {
        return $this->belongsTo(TaskFlowCollection::class);
    }

}
