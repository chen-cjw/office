<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function attributes()
    {
        return [
            'parent_id'=>'推荐人',
            'team_id'=>'团队名称',
        ];
    }
}
