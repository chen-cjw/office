<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    // 这里和普通的关系不大一样，暂时这样
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
