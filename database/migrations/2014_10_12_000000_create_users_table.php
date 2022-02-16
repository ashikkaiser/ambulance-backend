<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('system_id')->nullable();
            $table->string('name')->default('');
            $table->string('mobile')->unique();
            $table->string('email')->default('');
            $table->string('nid_number')->unique()->default('');
            $table->string('otp_token')->nullable();
            $table->string('pushToken')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->string('status')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('nid_picture')->nullable();
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
        Schema::dropIfExists('users');
    }
}
