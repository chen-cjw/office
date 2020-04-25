<?php

namespace App\Rules;

use App\Models\TeamMember;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class TeamUserRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * 判断团队里面是否有某个人，是否可创建任务，任务是需要分配给别人的
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isset = TeamMember::where('team_id',auth('api')->user()->team->id)->where('user_id',request()->assignment_user_id)->first();
        if ($isset) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '此用户不在我们的团队.';
    }
}
