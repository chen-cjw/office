<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class AuthMlOpenidStoreRequest extends FormRequest
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
            'code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => '授权失败！'
        ];
    }
}
