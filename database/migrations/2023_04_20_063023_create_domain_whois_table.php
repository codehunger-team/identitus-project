<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_whois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
            $table->string('registered_on')->nullable();
            $table->string('registrar')->nullable();
            $table->string('domain_age')->nullable();
            $table->string('registrant_country')->nullable();
            $table->json('nameservers')->nullable();
            $table->json('raw_response')->nullable();
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
        Schema::dropIfExists('domain_whois');
    }
};
