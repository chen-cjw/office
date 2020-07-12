<?php

namespace App\Http\Requests;

use App\Rules\TeamMemberRule;
use App\Rules\TeamRule;
use App\Rules\TeamUserRule;

class TaskRequest extends FormRequest
{
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
                    'content'=>['required',new TeamMemberRule()], // 提前有团队了
                    'images'=>'',
                    'close_date'=>['required','date',
                        function ($attribute, $value, $fail) {
                            if (bccomp(strtotime($value),strtotime(date('Y-m-d'))) == -1) {
                                return $fail('结束时间应该大于当前时间！');
                            }
                        }
                    ],
                    'task_flow'=>['required',
//                        function($attribute, $value, $fail) {
//                            if(!auth('api')->user()->taskFlowCollections()->where('name',$value)->first()) {
//                                return $fail('所选流程错误，请不要非法操作！');
//                            }
//                        }
                    ],
                    'status'=>'required|in:start,end,stop',
                    'assignment_user_id'=>['required',new TeamUserRule()]  // 这个人必须在团队里面
                ];
            case 'PUT':
                return [
                    'status' => ['required',''],
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
            'status'=>'状态',
            'assignment_user_id'=>'指派某人'
        ];
    }
}
