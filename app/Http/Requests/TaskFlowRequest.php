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
                'name'=>[
                    function ($attribute, $value, $fail) {
                        if($value) {
                            if (!TaskFlowCollection::where('user_id',auth('api')->id())->where('name',$value)->first()) {
                                return $fail('流程名称不存在！');
                            }
                        }
                    },
                ],

                'step_name'=>['required',
                    function ($attribute, $value, $fail) {
                        if($this->input('name')) {

                        }else {
                            if ($sku = TaskFlow::where('user_id',$this->input('user_id'))->where('step_name',$value)->first()) {
                                return $fail('流程步骤已存在！');
                            }
                        }
                    },
                ],
                'status'=>'required|in:start,pending,end,complete',
                'user_id'=>['required'] // 必须在用户表中，要在这个团队内
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
