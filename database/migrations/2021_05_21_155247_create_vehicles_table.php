<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->string('system_id');
            $table->string('vehicle_type');
            $table->string('sub_category')->nullable();
            $table->string('vehicle_number')->unique();
            $table->string('vehicle_color');
            $table->string('owner_name');
            $table->string('owner_nid');
            $table->string('owner_mobile');
            $table->string('owner_address');
            $table->string('status')->default('Pending');
            $table->string('accident_history')->nullable();
            $table->string('preferred_destination')->nullable();
            $table->string('created_by');
            $table->string('verified_by')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
