<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturnRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return_request_products', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('order_return_request_id')->unsigned();
	        $table->integer('order_product_id')->unsigned();
	        $table->integer('qty');
	        $table->timestamps();
            $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade');
	        $table->foreign('order_return_request_id')->references('id')->on('order_return_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_return_request_products');
    }
}
