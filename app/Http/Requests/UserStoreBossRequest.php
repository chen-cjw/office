<?php

namespace App\Http\Requests;

use App\Models\User;
use Dingo\Api\Http\FormRequest;

class UserStoreBossRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => ['unique:users,phone','regex:/^1[23456789][0-9]{9}$/',function ($attribute, $value, $fail) {
                    if(!User::where('id',$this->route('user'))->first()) {
                        return $fail('此用户不存在！');
                    }
                },
            ],
            'code' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'phone'=>'手机号码',
            'code'=>'授权失败',
        ];
    }
}
