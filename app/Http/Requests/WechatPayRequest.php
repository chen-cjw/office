<?php

namespace App\Http\Requests;

class WechatPayRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => ['required',
                    function($attribute, $value, $fail) {
                        if ($value <= 0) {
                            return $fail('人数不能小于0');
                        }
                        if (!auth('api')->user()->team()->exists()) {
                            return $fail('没有团队，无法支付');
                        }
                    }
                ],
            'day' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'number' => '人数',
            'day' => '时长',
        ];
        
    }
}
