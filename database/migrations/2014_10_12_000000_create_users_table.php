<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->integer('phone')->nullable();
            $table->string('user_name', 50)->nullable();
            $table->string('provider', 50)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('token')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status',['Guest', 'live'])->default('live');
            $table->boolean('verified')->default(0);
            $table->rememberToken();
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
