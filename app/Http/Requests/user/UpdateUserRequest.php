<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'roles'=>['nullable','array'],
            'roles.*'=>['exists:roles,id']
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'status'=>'failed',
                'message'=>'Failed Verification pelase confirm the input',
                'errors'=>$validator->errors()
            ])
            );
    }
    public function attributes(){
        return [
            'roles'=>'User Roles',
        ];
    }
    public function messages(){
        return [
            'exists'=>'The :attribute value does not correct'
        ];
    }
}
