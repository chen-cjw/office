<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    // start(开始)|end(结束)|stop(停止)

    protected $fillable = ['name','number_count','close_time','is_probation_period'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }

}
