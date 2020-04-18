<?php

namespace App\Http\Requests;

use App\Rules\TeamRule;
use Dingo\Api\Http\FormRequest;

class TeamRequest extends FormRequest
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
                    'name' => ['required','min:3','max:20','unique:teams,name',new TeamRule()],
                ];
            case 'PATCH':
                return [
                    'name' => ['min:3','max:20','unique:teams,name'],
                ];
            case 'DELETE':

            default:
                return [];
        }

    }

    public function attributes()
    {
        return [
            'name'=>'团队名称'
        ];
    }
}
