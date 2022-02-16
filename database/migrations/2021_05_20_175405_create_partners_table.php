<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('system_id');
            $table->string('category');
            $table->string('name');
            $table->string('mobile');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('nid');
            $table->string('trade_license')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('profile_picture');
            $table->string('nid_picture');
            $table->string('trade_license_picture')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('partners');
    }
}
