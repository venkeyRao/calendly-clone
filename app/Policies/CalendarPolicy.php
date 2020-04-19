<?php

namespace App\Policies;

use App\Models\{User, Calendar};
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy
{
    use HandlesAuthorization;

    public function delete(User $authUser, Calendar $slot)
    {
        if($slot->owner_id == $authUser->_id){  //Only owner of a slot is allowed to delete it 
            return true;
        }
        return false;
    }
}
