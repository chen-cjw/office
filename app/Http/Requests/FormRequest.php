<?php

namespace App\Http\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends \Dingo\Api\Http\FormRequest
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
    public function failedValidation($validator)
    {
        $error= $validator->errors()->all();
        throw new HttpResponseException(response()->json(['status_code'=>422,'message'=>$error[0]]));
    }
}
