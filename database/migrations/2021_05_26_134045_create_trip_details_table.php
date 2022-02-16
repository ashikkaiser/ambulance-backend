<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_details', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->string('booking_date');
            $table->string('ambulance_type');
            $table->string('vehicle_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('user_id');
            $table->string('booking_otp');
            $table->string('start_point');
            $table->string('end_point');
            $table->string('start_lat_long');
            $table->string('end_lat_long');
            $table->string('estimated_time');
            $table->string('estimated_distance');
            $table->integer('estimated_fair');
            $table->string('booking_status');
            $table->string('cancelled_by')->nullable();
            $table->string('final_distance')->nullable();
            $table->integer('final_fair')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('accident_history')->nullable();
            $table->string('trip_feedback')->nullable();
            $table->unsignedBigInteger('district');
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
        Schema::dropIfExists('trip_details');
    }
}
