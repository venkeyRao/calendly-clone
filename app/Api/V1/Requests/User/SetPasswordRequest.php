<?php

namespace App\Api\V1\Requests\User;

use App\Models\User;

use Dingo\Api\Http\FormRequest;

class SetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $rules = [
            'email_id' => ['required'],
       		'password' => ['required'],
       	];
        return $rules;
    }

    public function messages(){        
        
        return [
            
            'email_id.required' => 'Email is required',
            'email_id.email' => 'Email is invalid' , 
            'password.required' => 'Password is required',           
        ];
        
    }
}

?>