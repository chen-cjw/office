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
}
