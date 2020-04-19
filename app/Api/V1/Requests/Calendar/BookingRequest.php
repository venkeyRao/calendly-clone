<?php

namespace App\Api\V1\Requests\Calendar;

use Illuminate\Validation\Rule;
use Dingo\Api\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize()
    { 
        return true;
    }
    
    public function rules()
    {
        if(auth('api')->check()){
            return [];
        }

        return ['email' => ['required', 'string', 'email', 'max:255']];
    }
}

?>