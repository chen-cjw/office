<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = ['content','user_id','task_id'];
}
