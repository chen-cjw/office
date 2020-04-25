<?php

namespace App\Http\Requests;

use App\Models\TaskFlow;
use App\Models\TaskFlowCollection;
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
        return [
            'name'=>[
                function ($attribute, $value, $fail) {
                    if($value) {
                        if (TaskFlowCollection::where('user_id',auth('api')->id())->where('name',$value)->first()) {
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
    }

    public function attributes()
    {
        return [
            'step_name'=>'流程步骤名称',
            'status'=>'状态',
        ];
    }
}
