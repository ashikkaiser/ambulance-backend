<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Vehicle;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Assistant extends Model
{
    use HasFactory,SoftDeletes;

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

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function partner() {
        return $this->belongsTo(Partner::class);
    }
}
