<?php

namespace App\Http\Requests;

class DiscussRequest extends FormRequest
{
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
    public function attributes()
    {
        return [
            'content'=>'内容',
            'task_id'=>'某任务评论',
        ];
    }
}
