<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignRoleRequest extends FormRequest
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
            'roles'=>['required','array'],
            'roles.*'=>['exists:roles,id']
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(response()->json([
            'status'=>'failed',
            'message'=>'Failed Verification please cofirm the input',
            'errors'=>$validator->errors()
        ],422));
    }
    public function attributes(){
        return [
            'roles'=>'user Role'
        ];
    }
    public function messages(){
        return [
            'required'=>'The :attribute field is required',
            'exists'=>'The :attribute value is invalid'
        ];
    }
}
