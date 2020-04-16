<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class UserRequest extends FormRequest
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
            'parent_id'=>'',// 数据库必须存在
            'team_id'=>'',// 用户必须存在
//            'code'=>'required',

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
