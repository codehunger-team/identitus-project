<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateDnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns', function ($table) {
            $table->mediumText('identitius_nameserver1')->comment('	Name server to give identitius control.')->nullable()->change();
            $table->mediumText('identitius_nameserver2')->comment('Name server to give identitius control.')->nullable()->change();

            $table->mediumText('controller_nameserver1')->comment('Name server that domain controller wants the domain to point to.')->nullable()->change();
            $table->mediumText('controller_nameserver2')->comment('Name server that domain controller wants the domain to point to.')->nullable()->change();
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
