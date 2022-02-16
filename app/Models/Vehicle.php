<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Partner;
use App\Models\Assistant;
use App\Models\VehiclePicture;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'system_id',
        'vehicle_type',
        'sub_category',
        'vehicle_number',
        'vehicle_color',
        'owner_name',
        'owner_nid',
        'owner_mobile',
        'owner_address',
        'status',
        'preferred_destination',
        'created_by',
        'verified_by',
    ];

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function picture() {
        return $this->hasOne(VehiclePicture::class, 'vehicle_id');
    }

    public function partner() {
        return $this->belongsTo(Partner::class);
    }

    public function drivers() {
        return $this->hasMany(Driver::class, 'vehicle_id');
    }

    public function assistants() {
        return $this->hasMany(Assistant::class, 'vehicle_id');
    }

    public function trip() {
        return $this->hasOne(TripDetails::class, 'vehicle_id');
    }
}
