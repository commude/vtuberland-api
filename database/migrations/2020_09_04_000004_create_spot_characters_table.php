<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spot_characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spot_id');
            $table->uuid('character_id');
            $table->string('video_url')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('spot_characters');
    }
}
