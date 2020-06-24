<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class AuthRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'POST':
                return [
                    'phone' => 'unique:users,phone|regex:/^1[23456789][0-9]{9}$/',
                    'code' => 'required|string',
                ];
            case 'PUT':
                return [// 'administrator,admin,member,freeze,wait'
                    'status' => ['required','in:administrator,admin,member,freeze,wait,delete'],
                ];
            case 'DELETE':

            default:
                return [];
        }
        return [
            'phone' => 'unique:users,phone|regex:/^1[23456789][0-9]{9}$/',
            'code' => 'required|string',
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
