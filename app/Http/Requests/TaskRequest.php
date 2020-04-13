<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'images'=>'required',
            'close_date'=>'required',
            'task_flow'=>'required',
            'status'=>'required'
        ];
    }

    public function attributes()
    {
        return [
            'content'=>'内容',
            'images'=>'图片',
            'close_date'=>'截止日期',
            'task_flow'=>'任务流程',
            'status'=>'状态'
        ];
    }
}
