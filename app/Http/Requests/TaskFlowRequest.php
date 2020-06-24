<?php

namespace App\Http\Requests;

use App\Models\TaskFlow;
use App\Models\TaskFlowCollection;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
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
                    'name'=> 'required',
                    'task_flows'  => ['required', 'array'],
                    'task_flows.*.step_name' => [
                        'required'
                    ],
                    'task_flows.*.user_id' => [ // 检查 items 数组下每一个子数组的 sku_id 参数
                        'required',function($attribute, $value, $fail) {
                            if(TeamMember::where('user_id',auth('api')->id())->value('team_id') !== TeamMember::where('user_id',$value)->value('team_id')) {
                                return $fail('此用户不在我们团队！');
                            }
                        },
                    ],
                    'task_flows.*.status' => 'required|in:start,pending,end,complete'
            ];

            case 'PATCH':
                return [
                    'user_id' => ['required',
                        function($attribute, $value, $fail) {
                            $teamMember = TeamMember::where('user_id',$value)->first();
                            if($teamMember) {
                                if($teamMember->team_id != auth('api')->user()->team->id) {
                                    return $fail('此成员不在团队中！');
                                }
                            }else {
                                return $fail('此成员没有团队！');
                            }

                        }
                    ],
                ];
            case 'DELETE':

            default:
                return [];
        }


    }

    public function attributes()
    {
        return [
            'step_name'=>'流程步骤名称',
            'status'=>'状态',
        ];
    }
}
