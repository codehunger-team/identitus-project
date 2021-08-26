<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_offers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('lessor_id')->unsigned()->nullable();
            $table->foreign('lessor_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('lessee_id')->unsigned()->nullable();
            $table->foreign('lessee_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('contract_id')->nullable();

            $table->string('domain_name')->nullable();
            $table->float('first_payment', 10, 2)->nullable();
            $table->float('period_payment', 10, 2)->nullable();

            $table->integer('number_of_periods')->nullable();
            $table->float('option_purchase_price',10,2)->nullable();

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
        Schema::dropIfExists('counter_offers');
    }
}
