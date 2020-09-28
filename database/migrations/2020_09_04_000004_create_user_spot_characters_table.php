<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSpotCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_spot_characters', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('spot_id');
            $table->uuid('character_id');
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('spot_id')->references('id')->on('spots')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_spot_characters');
    }
}
