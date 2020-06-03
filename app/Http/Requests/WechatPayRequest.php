<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WechatPayRequest extends FormRequest
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
            'number' => 'required',
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
