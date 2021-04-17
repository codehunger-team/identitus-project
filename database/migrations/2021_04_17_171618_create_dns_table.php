<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dns', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('domain_id')->unsigned()->comment('Refers to domain.');;
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('dns_settings_id')->useCurrent()->comment('Timestampe to know the most recent dns settings.');
           
            $table->mediumText('identitius_nameserver1')->comment('	Name server to give identitius control.');
            $table->mediumText('identitius_nameserver2')->comment('Name server to give identitius control.');

            $table->mediumText('controller_nameserver1')->comment('Name server that domain controller wants the domain to point to.');
            $table->mediumText('controller_nameserver2')->comment('Name server that domain controller wants the domain to point to.');

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
        Schema::dropIfExists('dns');
    }
}
