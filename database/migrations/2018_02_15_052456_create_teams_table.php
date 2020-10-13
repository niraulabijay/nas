<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('slug')->nullable()->unique();
            $table->string('name', 50)->nullable();
            $table->string('position', 100)->nullable();
            $table->text('content')->nullable();
            $table->string('priority', 20)->nullable();
            $table->boolean('status')->default(0);
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('googleplus_link')->nullable();
            $table->string('linkedin_link')->nullable();
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
        Schema::dropIfExists('teams');
    }
}
