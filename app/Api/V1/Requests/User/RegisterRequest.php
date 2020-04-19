<?php

namespace App\Api\V1\Requests\User;

use App\Models\User;

use Dingo\Api\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return User::rules('register');
    }

    public function messages(){        
        
        return [
            'name.required' => 'Name is required',
            'name.regex:/^[A-Za-z_ \-\'\.\,]+$/' => 'Name is in improper format',
            'mobile.unique:users,mobile' => 'Mobile number is taken',
            'mobile.regex:/^([+][9][1]|[9][1]|[0]){0,1}([6-9]{1})([0-9]{9})$/' => 'Mobile number is in improper format',
            'email.unique:users,email' => 'Email is taken',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required'   
        ];
        
    }
}
