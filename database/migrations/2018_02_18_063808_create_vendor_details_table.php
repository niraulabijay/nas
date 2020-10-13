<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 100)->nullable();
            $table->longText('description')->nullable();
            $table->string('type',100)->nullable();
            $table->string('pan_number', 100)->nullable();
            $table->string('primary_email', 100)->nullable();
            $table->string('secondary_email', 100)->nullable();
            $table->string('primary_phone', 100)->nullable();
            $table->string('secondary_phone', 100)->nullable();
            $table->longText('address', 100)->nullable();
            $table->string('seo_keywords', 100)->nullable();
            $table->longText('seo_description')->nullable();
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
        Schema::dropIfExists('vendor_details');
    }
}
