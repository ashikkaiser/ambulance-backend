<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Assistant;
// use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'system_id', 'category', 'name', 'mobile', 'company', 'email', 'password', 'nid', 'trade_license', 
        'address', 'city', 'postal_code', 'profile_picture', 'nid_picture', 'trade_license_picture', 'status', 'created_by', 'verified_by'
    ];

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function vehicles() {
        return $this->hasMany(Vehicle::class, 'partner_id');
    }

    public function drivers() {
        return $this->hasMany(Driver::class, 'partner_id');
    }

    public function assistants() {
        return $this->hasMany(Assistant::class, 'partner_id');
    }

}
