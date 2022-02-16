<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderators', function (Blueprint $table) {
            $table->id();
            $table->string('system_id');
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nid')->unique();
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('profile_pic');
            $table->string('nid_pic');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('moderators');
    }
}
