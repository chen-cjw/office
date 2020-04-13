<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class TeamRequest extends FormRequest
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
            'name' => 'required|unique:teams|min:3|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'团队名称'
        ];
    }
}
