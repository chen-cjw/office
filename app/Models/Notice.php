<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['to_user_id','send_user_id','content','is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
