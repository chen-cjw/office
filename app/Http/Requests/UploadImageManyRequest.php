<?php

namespace App\Http\Requests;

class UploadImageManyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'images' =>'required'
        ];
    }

    public function messages()
    {
        return [
            'images' => '图片'
        ];
    }
}
