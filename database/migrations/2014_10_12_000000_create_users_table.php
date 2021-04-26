<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->string('name');
            $table->string('email')->unique();

            $table->integer('admin')->comment('if admin value = 1 else value = 0')->nullable();

            $table->string('street_1')->nullable();
            $table->string('street_2')->nullable();

            $table->string('city')->nullable();
            $table->string('state')->nullable();

            $table->string('zip')->nullable();

            $table->string('country')->nullable();

            $table->string('company')->nullable();
            $table->string('phone')->nullable();

            $table->enum('is_vendor', ['no', 'yes','pending']);
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->string('stripe_account_id')->nullable();

            $table->rememberToken();
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
