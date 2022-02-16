<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Fare extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
