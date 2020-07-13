<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\TeamRule;

class TeamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                return [
                    'name' => ['required','min:3','max:20','unique:teams,name',new TeamRule(),
                        function ($attribute, $value, $fail) {
                            if (auth('api')->user()->status != User::REFUND_STATUS_ADMINISTRATOR || auth('api')->user()->send_invite_set_id != 2) {
                                return $fail('此用户不是超级管理员/老板！');
                            }
                        },
                    ],
                ];
            case 'PATCH':
                return [
                    'name' => ['min:3','max:20','unique:teams,name,'.auth('api')->user()->team->id],
                ];
            case 'DELETE':

            default:
                return [];
        }

    }

    public function attributes()
    {
        return [
            'name'=>'团队名称'
        ];
    }
}
