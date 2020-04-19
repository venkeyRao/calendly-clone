<?php

namespace App\Api\V1\Requests\Calendar;

use Illuminate\Validation\Rule;
use App\Models\Calendar;
use Dingo\Api\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    { 
        return true;
    }
    
    public function rules()
    {
        return Calendar::rules();
    }

}

?>