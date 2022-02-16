<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\SystemRevenue;
use Jenssegers\Mongodb\Eloquent\Model;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class TripDetails extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'booking_id',
        'booking_date',
        'ambulance_type',
        'vehicle_id',
        'driver_id',
        'user_id',
        'booking_otp',
        'start_point',
        'end_point',
        'start_lat_long',
        'end_lat_long',
        'estimated_time',
        'estimated_distance',
        'estimated_fair',
        'booking_status',
        'cancelled_by',
        'final_distance',
        'final_fair',
        'discount_amount',
        'payment_method',
        'accident_history',
        'trip_feedback',
    ];

    protected $dates = ['created_at', 'updated_at', 'booking_date','deleted_at'];

    public function systemRevenue()
    {
        return $this->hasOne(SystemRevenue::class, 'trip_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function category(){
        return $this->belongsTo(VehiclesCategory::class,'ambulance_type');
    }


}
