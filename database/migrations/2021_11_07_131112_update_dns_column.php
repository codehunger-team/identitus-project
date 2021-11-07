<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDnsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns', function ($table) {
            $table->mediumText('identitius_nameserver1')->comment('	Name server to give identitius control.')->default(NULL)->change();
            $table->mediumText('identitius_nameserver2')->comment('Name server to give identitius control.')->default(NULL)->change();

            $table->mediumText('controller_nameserver1')->comment('Name server that domain controller wants the domain to point to.')->default(NULL)->change();
            $table->mediumText('controller_nameserver2')->comment('Name server that domain controller wants the domain to point to.')->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
