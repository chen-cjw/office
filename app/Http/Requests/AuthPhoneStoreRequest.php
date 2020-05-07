<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

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
            'code'           => 'require',
            'encrypted_data' => 'require',
            'iv'             => 'require',
        ];
    }

    public function messages()
    {
        return [
            'code.require'=>'授权失败！',
            'encrypted_data.require'=>'加密的用户数据不能为空！',
            'iv.require'=>'与用户数据一同返回的初始向量不能为空！',
        ];
    }
}
