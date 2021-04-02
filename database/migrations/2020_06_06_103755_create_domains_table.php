<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();

            $table->string('domain')->nullable()->comment('Domain name. Each is unique. Domains have a max of 253 characters including the dot.');
            
            $table->longText('tags')->nullable()->comment('Tags created by the domain owner.');

            $table->mediumText('category')->nullable()->comment('Category of domain');
            $table->mediumText('description')->nullable()->comment('Description area for domain owner.');

            $table->foreignId('user_id')
                ->comment('This is the owner of the domain.')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('registrar_id')
                ->comment('This is the owner of the domain.')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('pricing')->nullable();

            $table->string('reg_date')->nullable();

            $table->string('short_description')->nullable();

            $table->string('domain_logo')->nullable();

            $table->enum('domain_status', ['AVAILABLE', 'SOLD']);

            $table->integer('discount')->nullable();

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
        Schema::dropIfExists('domains');
    }
}
