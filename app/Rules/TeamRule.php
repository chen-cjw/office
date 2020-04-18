<?php

namespace App\Rules;

use App\Models\TeamMember;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class TeamRule implements Rule
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
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isset = TeamMember::where('user_id',auth('api')->id())->first();
        if ($isset) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '此用户已加入团队.';
    }
}
