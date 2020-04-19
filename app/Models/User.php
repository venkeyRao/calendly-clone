<?php

namespace App\Models;

use App\Rules\UniqueEmail;
use Illuminate\Validation\Rule;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ForgetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use DesignMyNight\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DISABLED = 'disabled';

    public static $statuses = [
        self::STATUS_PENDING => ['label' => 'Pending'],
        self::STATUS_APPROVED => ['label' => 'Approved'],
        self::STATUS_DISABLED => ['label' => 'Disabled'],
    ];

    const ROLE_CALANDLY_USER = 'calandly_user';

    public static $roles = [
        self::ROLE_CALANDLY_USER => ['label' => 'Calandly User'],
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'role',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_APPROVED,
        'role' => self::ROLE_CALANDLY_USER,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setEmailAttribute($value)
    {
      $this->attributes['email'] = strtolower($value);
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return
     *  array
     */

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
        ];
    }

    public static function rules($scenario)
    {
        switch($scenario)
        {
            case 'login':
                $rules = [
                    'username' => ['required'],
                    'password' => ['required'],
                ];
                break;
            case 'register':
                $rules = [
                    'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z_ \-\'\.\,]+$/'],
                    'mobile' => ['required','digits:10', 'regex:/^([+][9][1]|[9][1]|[0]){0,1}([6-9]{1})([0-9]{9})$/'],
                    'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail ],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'password_confirmation' => ['required'],
                ];
                break;
            default :
                $rules = [
                    'email' => ['string', 'email', 'required', new UniqueEmail ],
                    'mobile' => ['required', 'required', 'regex:^[6-9]\d{9}$^'],
                    'name' => ['string', 'required', 'regex:/^[A-Za-z_ \-\'\.\,]+$/'],
                    'password' => ['required', 'string', 'min:6'],
                ];
        }
        return $rules;
    }

    // Relations

    public function bookedSlots()
    {
        return $this->hasMany('App\Models\Calendar', 'booked_by', 'email');
    }

    public function ownedSlots()
    {
        return $this->hasMany('App\Models\Calendar', 'owner_id', '_id');
    }

    // Notifications

    public function ForgotPasswordNotification($token)
    {
        $this->notify(new ForgetPassword([$token]));
    }

}
