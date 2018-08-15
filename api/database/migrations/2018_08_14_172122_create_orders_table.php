<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('description', 2048)->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('order_type_id');
            $table->unsignedInteger('order_history_id')->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('order_type_id')->references('id')->on('order_type');
            $table->foreign('order_history_id')->references('id')->on('order_history');
        });

        Schema::table('order_history', function($table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_history', function($table) {
            $table->dropForeign('order_history_order_id_foreign');
        });

        Schema::dropIfExists('orders');
    }
}
