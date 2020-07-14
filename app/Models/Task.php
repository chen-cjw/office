<?php

namespace App\Models;

class Task extends ImageUpload
{
    const REFUND_STATUS = 'start';
    const REFUND_END = 'end';
    const REFUND_STOP = 'stop';
    const REFUND_PENDING = 'pending';
    const REFUND_COMPLETE = 'complete';
    const REFUND_OVERDUE = 'overdue';

    public static $status = [
        self::REFUND_STATUS => '开始',
        self::REFUND_END => '结束',
        self::REFUND_STOP => '停止',
        self::REFUND_PENDING    => '进行中',
        self::REFUND_COMPLETE    => '完成',
        self::REFUND_OVERDUE    => '逾期',
    ];

    protected $fillable = [
        'content','images','close_date','task_flow','status','assignment_user_id','task_id'
    ];

    public function assignmentUser()
    {
        return $this->belongsTo(User::class,'assignment_user_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
//        return $this->belongsTo(User::class,'assignment_user_id','id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class,'task_id','id');
    }

    public function discusses()
    {
        return $this->hasMany(Discuss::class);
    }

    public function taskLogs()
    {
        return $this->morphMany(TaskLog::class,'model');//->orderBy('id','desc');
    }

}
