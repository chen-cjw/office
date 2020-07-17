<?php

namespace App\Http\Requests;

use App\Models\Task;
use App\Models\Team;
use App\Models\TeamMember;

class SubTaskRequest extends FormRequest
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
                    'content' => ['required'],
                    'close_date' => ['required','date',
                        function ($attribute, $value, $fail) {
                            //if (strtotime($value)<time()) {
                            if (bccomp(strtotime($value),strtotime(date('Y-m-d'))) == -1) {
                                    return $fail('结束时间应该大于当前时间！');
                            }
                        }
                    ],
                    'task_flow' => ['required'],
                    'task_id' => ['required',
                        function ($attribute, $value, $fail) {
                            if (Task::where('id',$value)->value('task_id')) {
                                return $fail('子任务不可以在创建子任务！');
                            }
                            if($value) {
                                if (!auth('api')->user()->subTasks()->where('id',$value)->first()) {
                                    return $fail('任务不存在！');
                                }
                            }
                        }
                    ],
                    'user_id' => ['required',
                        function ($attribute, $value, $fail) {
                            $teamId = auth('api')->user()->teams[0]->id;
                            if (!TeamMember::where('team_id', $teamId)->where('user_id',$value)->first()) {
                                return $fail('此用户不是我们团队的！');
                            }
                        },
                    ],
                    'status' => ['required','in:start,end,stop,pending,complete,overdue'],
                ];
            case 'PUT':
                return [
                    'status' => ['required'],
                ];
            case 'DELETE':

            default:
                return [];
        }
    }
}
