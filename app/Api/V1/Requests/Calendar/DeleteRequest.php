<?php

namespace App\Api\V1\Requests\Calendar;

use Auth;
use Illuminate\Validation\Rule;
use Dingo\Api\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    { 
        return $this->user()->can('delete', $this->route('slot'));
    }
    
    public function rules()
    {
        return [];
    }
   
}

?>