<?php

namespace App\Models;

class Subtask extends ImageUpload
{
    //进行中(pending)|完成(complete)|逾期(overdue)|停止(stop)
    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_COMPLETE = 'complete';
    const REFUND_STATUS_OVERDUE = 'overdue';
    const REFUND_STATUS_STOP = 'stop';
    public static $status = [
        self::REFUND_STATUS_PENDING    => '进行中',
        self::REFUND_STATUS_COMPLETE    => '完成',
        self::REFUND_STATUS_OVERDUE    => '逾期',
        self::REFUND_STATUS_STOP    => '停止',
    ];

    protected $fillable = ['content','images','task_id','close_date','task_flow','status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
