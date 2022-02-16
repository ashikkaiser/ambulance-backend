<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_pictures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('vehicle_1_pic');
            $table->string('vehicle_2_pic');
            $table->string('smart_card_pic');
            $table->string('tax_token_pic');
            $table->string('fitness_pic');
            $table->string('insurance_pic');
            $table->string('owner_profile_pic');
            $table->string('owner_nid_pic');
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
        Schema::dropIfExists('vehicle_pictures');
    }
}
