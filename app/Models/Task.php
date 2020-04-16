<?php

namespace App\Models;

class Task extends ImageUpload
{
    const REFUND_STATUS = 'start';
    const REFUND_END = 'end';
    const REFUND_STOP = 'stop';
    public static $status = [
        self::REFUND_STATUS => '开始',
        self::REFUND_END => '结束',
        self::REFUND_STOP => '停止',
    ];

    protected $fillable = [
        'content','images','close_date','task_flow','status'
    ];

    public function subtasks()
    {
        return $this->hasMany(Subtask::class,'task_id','id');
    }

    public function discusses()
    {
        return $this->hasMany(Discuss::class);
    }

}
