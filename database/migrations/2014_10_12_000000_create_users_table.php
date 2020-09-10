<?php

use App\Enums\Locale;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            // $table->string('username')->unique();
            $table->string('email')->unique();
            // $table->boolean('is_valid')->default(0);
            // $table->string('password');
            // $table->rememberToken();
            $table->string('password')->nullable();
            $table->text('manufacturer');
            $table->text('os');
            $table->text('version')->nullable();
            $table->string('language')->default(Locale::JAPAN);
            $table->string('token')->unique();
            $table->boolean('is_valid')->default(0);
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
        Schema::dropIfExists('users');
    }
}
