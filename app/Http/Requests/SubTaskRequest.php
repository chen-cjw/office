<?php

namespace App\Http\Requests;

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
