<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'name'=>['required','unique:users,name','string','max:40','unique:users,name'],
            'email'=>['required','email','unique:users,email'],
            'password'=>['required','string','min:8']
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new  HttpResponseException(
            response()->json([
                'status'=>'failed',
                'message'=>'Failed Verification please confirm the input',
                'errors'=>$validator->errors()
            ],422),
            );
    }
    public function attributes()
    {
        return [
            'name'=>'user name',
            'email'=>'user email',
            'password'=>'user password'
        ];
    }
    public function messages(){
        return [
            'required'=>'Error : The :attribute field is required',
            'unique'=>'Error : The :attribute Value is already exists',
            'email'=>'Error : please enter a valid email',
            'string'=>'Error : The :attribute must be a string'
        ];
    }
}
