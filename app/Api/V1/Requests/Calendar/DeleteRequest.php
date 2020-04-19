<?php

namespace App\Api\V1\Requests\Calendar;

use Auth;
use Illuminate\Validation\Rule;
use Dingo\Api\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    { 
        //Policy is invoked to check if logged-in user has permission to delete this slot object - will return 403 forbidden on faliure 
        return $this->user()->can('delete', $this->route('slot'));
    }
    
    public function rules()
    {
        return [];
    }
   
}

?>