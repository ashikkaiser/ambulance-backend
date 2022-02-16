<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_name',
        'Splash_Page',
        'Profile_image', 
        'Splash_Screen',
        'App_logo',
        'Organigation_name',
        'App_Header',
        'Button_Colour_primary',
        'Button_Colour_Secondary',
        'Button_text_primary',
        'Button_text_secondary',
        'App_colour_primary',
        'App_colour_secondary',
    ];

}
