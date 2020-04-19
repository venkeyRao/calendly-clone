<?php

namespace App\Api\V1\Requests\Calendar;

use Auth;
use Illuminate\Validation\Rule;
use Dingo\Api\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function authorize()
    { 
        return true;
    }
    
    public function rules()
    {
        return [];
    }
   
}

?>