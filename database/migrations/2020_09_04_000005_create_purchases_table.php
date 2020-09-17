<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->text('product_id')->nullable();
            $table->text('bundle_id')->nullable();
            $table->text('download_id')->nullable();
            $table->text('purchase_token')->nullable();
            $table->longText('receipt')->nullable();
            $table->text('currency')->nullable();
            $table->integer('status')->index();
            $table->dateTime('purchased_at')->nullable();
            $table->longText('exception_message')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
