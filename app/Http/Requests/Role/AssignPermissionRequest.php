<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignPermissionRequest extends FormRequest
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
            'permission_id'=>['required','array'],
            'permission_id.*'=>['exists:permissions,id']
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(
            response()->json([
                'status'=>'failed',
                'message'=>'Failed Validation please confirm the input',
                'errors'=>$validator->errors()
            ],422)
            );
    }
    public function attributes(){
        return [
            'permission_id'=>'permission ID'
        ];
    }
    public function messages(){
        return [
            'required'=>'The :attribute field is required',
            'array'=>'The :attribute field must be an array',
            'exists'=>'The :attribute value is not correct'
        ];
    }
}
