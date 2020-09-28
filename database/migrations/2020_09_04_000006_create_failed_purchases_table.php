<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->uuid('user_id');
            $table->uuid('spot_id');
            $table->uuid('character_id');
            $table->timestamps();

            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('spot_id')->references('id')->on('spots');
            $table->foreign('character_id')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_purchases');
    }
}
