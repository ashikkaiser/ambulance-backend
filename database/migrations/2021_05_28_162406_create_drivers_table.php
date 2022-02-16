<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('system_id');
            $table->string('otp_token')->nullable();
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('nid')->unique();
            $table->string('driving_license')->unique();
            $table->string('address');            
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('status')->default('Pending');
            $table->string('profile_pic');
            $table->string('nid_pic');
            $table->string('driving_license_pic');
            $table->string('online_status')->default('0');
            $table->string('pushToken')->nullable();
            $table->unsignedBigInteger('preferred_destination')->default(0);
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
        Schema::dropIfExists('drivers');
    }
}
