<?php

namespace App\Http\Requests;

class TaskFlowUpdateStatusRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'=>'required|in:start,end,stop'
        ];
    }
}
