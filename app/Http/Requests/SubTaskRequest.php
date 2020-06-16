<?php

namespace App\Http\Requests;

use App\Models\Team;
use App\Models\TeamMember;
use Dingo\Api\Http\FormRequest;

class SubTaskRequest extends FormRequest
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
                    'content' => ['required'],
                    'close_date' => ['required'],
                    'task_flow' => ['required'],
                    'task_id' => ['required',
                        function ($attribute, $value, $fail) {
                            if($value) {
                                if (!auth('api')->user()->tasks()->where('id',$value)->first()) {
                                    return $fail('任务不存在！');
                                }
                            }
                        }
                    ],
                    'user_id' => ['required',
                        function ($attribute, $value, $fail) {
                            if($value) {
                                $teamId = auth('api')->user()->team()->value('id');
                                if (!TeamMember::where('team_id', $teamId)->first()) {
                                    return $fail('此用户不是我们团队的！');
                                }
                            }
                        },
                    ],
                    'status' => ['required'],
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
}
