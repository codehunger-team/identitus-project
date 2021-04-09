<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('contracts', function (Blueprint $table) {
            
            $table->increments('contract_id');
            $table->foreignId('domain_id')->constrained()->onDelete('cascade');

            $table->integer('lessor_id')->nullable();
            $table->integer('lessee_id')->nullable();
            
            $table->string('option_price')->nullable();
            $table->string('option_expiration')->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->string('first_payment')->nullable();
            $table->string('period_payment')->nullable();

            $table->integer('period_type_id')->nullable();
            $table->integer('number_of_periods')->nullable();

            $table->dateTime('payment_due_date', 0)->nullable();
            $table->integer('grace_period_id')->nullable();

            $table->integer('contract_status_id')->nullable();
            $table->string('release_payment')->nullable();

            $table->string('lease_total')->nullable();
            $table->integer('auto_change_rate')->nullable();

            $table->decimal('accrual_rate', $precision = 10, $scale = 0);

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
        Schema::dropIfExists('contracts');
    }
}
