<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Agent extends Model
{
    use HasFactory, SoftDeletes;



    protected $fillable = [
        'system_id', 'name', 'mobile', 'email', 'password', 'nid', 'address', 'city', 'postal_code', 'profile_pic', 'nid_pic', 'status'
    ];

    protected $hidden = ['password',];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
