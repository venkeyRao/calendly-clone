<?php

namespace App\Api\V1\Requests\Calendar;

use Auth;
use App\Models\Calendar;
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
        return [
            'status' => ['nullable', Rule::in(Calendar::STATUS_AVAILABLE, Calendar::STATUS_BOOKED)],
            'scope' => ['nullable', Rule::in('created_by_me')],
        ];
    }
   
}

?>