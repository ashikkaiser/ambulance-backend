<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'email', 'password', 'user_category', 'status'
    ];

    protected $hidden = ['password'];

    protected $dates = ['created_at', 'updated_at','deleted_at'];
}