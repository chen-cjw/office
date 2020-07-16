<?php

namespace App\Http\Requests;

use App\Models\Task;
use App\Models\Team;
use App\Models\TeamMember;

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
            'content'=>['required',

                ],
            'task_id'=>['required',function($attribute, $value, $fail) {
                $taskUserId = Task::where('id',$value)->value('user_id');
                if (TeamMember::where('user_id',$taskUserId)->value('team_id') != TeamMember::where('user_id',auth('api')->id())->value('team_id')) {
                    return $fail('此用户不在我们团队！');
                }
            }],
//            'images'=>'required',
            'comment_user_id'=>[
                function($attribute, $value, $fail) {
//                    if (auth('api')->user()->id == $value) {
//                        return $fail('自己不能回复自己！');
//                    }
                    if (TeamMember::where('user_id',$value)->value('team_id') != TeamMember::where('user_id',auth('api')->id())->value('team_id')) {
                        return $fail('此用户不在我们团队！');
                    }
                },
            ],
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
