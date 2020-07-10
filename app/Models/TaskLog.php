<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = ['content','user_id','model_id','model_type'];

    public function model()
    {
        return $this->morphTo();
    }
}
