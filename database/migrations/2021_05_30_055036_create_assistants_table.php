<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('system_id');
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('nid')->unique();
            $table->string('driving_license')->nullable();
            $table->string('address');            
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('status')->default('Pending');
            $table->string('profile_pic');
            $table->string('nid_pic');
            $table->string('driving_license_pic')->nullable();
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
        Schema::dropIfExists('assistants');
    }
}
