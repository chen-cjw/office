<?php

namespace App\Models;

class Task extends ImageUpload
{

    protected $fillable = [
        'content','images','close_date','task_flow','status'
    ];



}
