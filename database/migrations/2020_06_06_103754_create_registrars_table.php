<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrars', function (Blueprint $table) {
            $table->id();

            $table->mediumtext('registrar')->nullable();

            $table->mediumText('registrar_url')->nullable();

            $table->mediumText('registrar_street1')->nullable();
            $table->mediumText('registrar_street2')->nullable();

            $table->mediumText('registrar_city')->nullable();
            $table->mediumText('registrar_state')->nullable();

            $table->mediumText('registrar_zip')->nullable();
            $table->mediumText('registrar_country')->nullable();

            $table->mediumText('registrar_contact_name')->nullable();
            $table->mediumText('registrar_contact_phone')->nullable();

            $table->mediumText('registrar_contact_email')->nullable();

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
        Schema::dropIfExists('registrars');
    }
}
