<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class DiscussRequest extends FormRequest
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
            'content'=>'required',
            'task_id'=>'required',
//            'images'=>'required',
//            'comment_user_id'=>'required',
        ];
    }
}
