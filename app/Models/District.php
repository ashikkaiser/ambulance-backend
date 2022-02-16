<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class District extends Model
{
    use HasFactory;
    // use UseAutoIncrementID;
    protected $fillable = [
        'name_en',
        'name_bn',
        'lat',
        'long',
    ];

    protected $dates = ['created_at', 'updated_at'];
}
