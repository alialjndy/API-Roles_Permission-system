<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRoleRequest extends FormRequest
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
            'name'=>'required|string|max:100|unique:roles,name',
            'description'=>'nullable|string|max:255'
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
            'name'=>'role name',
            'description'=>'role description'
        ];
    }
    public function messages(){
        return [
            'unique'=>'The :attribute value must be a unique',
            'required'=>'The :attribute field is required',
            'string'=>'The :attribute value must be a string',
            'max'=>'The :attribute field max character is :max'
        ];
    }
}
