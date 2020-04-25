<?php

namespace App\Rules;

use App\Models\TeamMember;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class TaskFlowStepNameUserUniqueRule implements Rule
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
        $isset = TeamMember::where('user_id',auth('api')->id())->first();
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
        return '团队未创建/团队没有成员.';
    }
}
