<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Vehicle;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'vehicle_id',
        'system_id',
        'name',
        'mobile',
        'nid',
        'driving_license',
        'address',
        'city',
        'postal_code',
        'status',
        'profile_pic',
        'nid_pic',
        'driving_license_pic',
        'status',
        'created_by',
        'verified_by',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function trip()
    {
        return $this->hasOne(TripDetails::class, 'driver_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
