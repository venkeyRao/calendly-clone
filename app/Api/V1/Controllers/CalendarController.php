<?php

namespace App\Api\V1\Controllers;

use Log;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\{User, Calendar};
use App\Api\V1\Controllers\Controller;
use App\Api\V1\Resources\CalendarResource;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Api\V1\Requests\Calendar\{ListRequest, CreateRequest, ViewRequest, DeleteRequest, BookingRequest};

class CalendarController extends Controller
{
   
    public function index(ListRequest $request)
    {
       $slots = Calendar::when($request->filled('status'), function($query) use($request){
                    $query->where('status', $request->status);
                })->when($request->filled('scope') && auth('api')->check(), function($query){
                    $query->where('owner_id', auth('api')->user()->_id);
                });

        return CalendarResource::collection($slots->paginate($request->get('page_size')));
    }

    public function store(CreateRequest $request)
    {   
        $slot = new Calendar;
        $slot->date = $request->date;
        $slot->time_slot = $request->time_slot.' - '.date('H:i', (strtotime($request->time_slot) + 60*60));
        $slot->owner_id = auth('api')->user()->_id;
        $slot->save();
        return (new CalendarResource($slot))->response()->setStatusCode(201);
    }

    public function show(ViewRequest $request, Calendar $slot)
    {   
        return (new CalendarResource($slot))->response()->setStatusCode(200);
    }

    public function destroy(DeleteRequest $request, Calendar $slot)
    {
        $slot->delete();
        return $this->response->noContent();
    }

    public function bookSlot(BookingRequest $request, Calendar $slot)
    {
        if($slot->status != Calendar::STATUS_AVAILABLE){
            throw new StoreResourceFailedException("Slot Already Booked Or Unavaiable!");
        }
        $slot->booked_by = auth('api')->check() ? auth('api')->user()->email : $request->email;
        $slot->status = Calendar::STATUS_BOOKED;
        $slot->save();
        return (new CalendarResource($slot))->response()->setStatusCode(200);
    }
}
