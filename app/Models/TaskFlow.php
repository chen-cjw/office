<?php

namespace App\Models;

class TaskFlow extends ImageUpload
{
    protected $fillable = [
        'content','images','close_date','task_flow','status'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
