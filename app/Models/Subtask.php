<?php

namespace App\Models;

class Subtask extends ImageUpload
{

    const REFUND_STATUS_ADMINISTRATOR = 'administrator';
    public static $status = [
        self::REFUND_STATUS_ADMINISTRATOR    => '超级管理员',

    ];


    protected $fillable = ['content','images','task_id','close_date','task_flow','status'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
