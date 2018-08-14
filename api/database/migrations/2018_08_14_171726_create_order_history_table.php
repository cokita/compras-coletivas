<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observation', 2048)->nullable();
            $table->boolean('active')->default(true);
            $table->dateTime('status_limit_date');
            $table->string('tracking_code', 1024)->nullable();
            $table->unsignedInteger('order_id')->unique();
            $table->unsignedInteger('order_status_id')->unique();
            $table->timestamps();

            $table->foreign('order_status_id')->references('id')->on('order_status');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_history');
    }
}
