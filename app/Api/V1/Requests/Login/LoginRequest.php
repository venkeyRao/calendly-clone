<?php

namespace App\Api\V1\Requests\Login;

use App\Models\User;

use Dingo\Api\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return User::rules('login');
    }
   
}

?>