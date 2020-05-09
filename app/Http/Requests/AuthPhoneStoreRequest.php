<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthPhoneStoreRequest extends FormRequest
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
