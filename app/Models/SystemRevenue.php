<?php

namespace App\Models;

use App\Models\TripDetails;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class SystemRevenue extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = ['payment_amount', 'trip_id'];

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function tripDetails() {
        return $this->belongsTo(TripDetails::class);
    }
}
