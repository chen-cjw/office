<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFlowCollection extends Model
{
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskFlows()
    {
        return $this->hasMany(TaskFlow::class);
    }
}
