<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('character_id')->nullable();
            $table->text('original_transaction_id')->nullable();
            $table->text('transaction_id')->nullable(); // transaction_id from apple or google
            $table->text('purchase_token')->nullable(); // for google's response
            $table->longText('receipt')->nullable(); // from the app side
            $table->text('currency')->nullable();
            $table->integer('status')->index();
            $table->dateTime('purchased_at')->nullable(); // date from the receipt
            $table->dateTime('expired_at')->nullable(); // expiration_date from the receipt
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
        Schema::dropIfExists('transactions');
    }
}
