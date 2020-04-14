<?php

namespace App\Models;

class Task extends ImageUpload
{

    const REFUND_STATUS_ADMINISTRATOR = 'administrator';
    public static $status = [
        self::REFUND_STATUS_ADMINISTRATOR    => '超级管理员',

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
