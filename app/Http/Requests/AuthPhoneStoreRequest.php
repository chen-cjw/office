<?php

namespace App\Http\Requests;

class AuthPhoneStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'=>'required',
            'encrypted_data'=>'required',
            'iv'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'code.require'           => '缺少参数code!',
            'encrypted_data.require' => '缺少参数encrypted_data!',
            'iv.require'             => '缺少参数iv!',
        ];

    }
}
