<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'subject',
        'body',
    ];

    protected $dates = [
        'created_at', 'updated_at','deleted_at'
    ];
}
