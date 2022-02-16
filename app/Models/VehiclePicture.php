<?php

namespace App\Models;

use App\Models\Vehicle;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
class VehiclePicture extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'vehicle_1_pic',
        'vehicle_2_pic',
        'smart_card_pic',
        'tax_token_pic',
        'fitness_pic',
        'insurance_pic',
        'owner_profile_pic',
        'owner_nid_pic',
    ];

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
