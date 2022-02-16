<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_name');
            $table->string('Splash_Page')->nullable();
            $table->string('Profile_image')->nullable(); 
            $table->string('Splash_Screen')->nullable();
            $table->string('App_logo')->nullable();
            $table->string('Organigation_name')->nullable();
            $table->string('App_Header')->nullable();
            $table->string('Button_Colour_primary')->nullable();
            $table->string('Button_Colour_Secondary')->nullable();
            $table->string('Button_text_primary')->nullable();
            $table->string('Button_text_secondary')->nullable();
            $table->string('App_colour_primary')->nullable();
            $table->string('App_colour_secondary')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
}
