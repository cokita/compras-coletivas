<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('action_id');
            $table->timestamps();
            $table->boolean('active')->default(true);

            $table->foreign('action_id')->references('id')->on('actions');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_actions');
    }
}
