<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_detail_id')->unsigned();
            $table->foreign('vendor_detail_id')->references('id')->on('vendor_details')->onDelete('cascade');
            $table->string('facebook_url', 100)->nullable();
            $table->string('google_url', 100)->nullable();
            $table->string('twitter_url', 100)->nullable();
            $table->string('instagram_url', 100)->nullable();
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
        Schema::dropIfExists('vendor_socials');
    }
}
