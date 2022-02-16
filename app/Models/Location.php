<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use App\Traits\UseAutoIncrementID;

class Location extends Model
{
    use HasFactory;
    // use UseAutoIncrementID;

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
