<?php

namespace App\Models;

class Discuss extends ImageUpload
{
    protected $fillable = ['content','images','task_id','comment_user_id','reply_user_id'];

}
