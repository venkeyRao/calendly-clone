<?php

namespace App\Models;
use Illuminate\Validation\Rule;
use Jenssegers\Mongodb\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'date',
        'time_slot',
        'owner_id',
        'status',
        'booked_by',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_BOOKED = 'booked';

    protected $attributes = [
        'status' => self::STATUS_AVAILABLE,
    ];

    public static function rules()
    {
        $rules = [
            'date' => ['required','date', 'date_format:d-m-Y',],
            'time_slot' => ['required', 'date_format:H:i'],
        ];
        return $rules;
    }

    // Relations

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', '_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\User', 'booked_by', 'email');
    }

}
