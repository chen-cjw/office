<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class TaskFlowRequest extends FormRequest
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
                    'content'=>'required',
                    'images'=>'',
                    'close_date'=>'required',
                    'task_flow'=>'required',
                    'status'=>'required'
                ];
            case 'PATCH':
                return [
                    'status' => ['required'],
                ];
            case 'DELETE':

            default:
                return [];
        }

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
