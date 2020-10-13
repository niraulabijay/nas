<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dispute_id')->unsigned();
            $table->foreign('dispute_id')->references('id')->on('disputes')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('dispute_messages');
    }
}
