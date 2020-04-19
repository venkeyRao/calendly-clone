<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {  
        return  [
            'id' => $this->_id,
            'date' => $this->date,
            'time_slot' => $this->time_slot,
            'status' => $this->status,
            'owner_id' => $this->owner_id,
            'booked_by' => $this->booked_by,
            'owner' => new UserResource($this->owner),
            'client' => new UserResource($this->client),
        ];
    }
}
