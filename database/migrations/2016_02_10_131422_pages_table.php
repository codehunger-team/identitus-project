<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

    class PagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create pages cms table
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('page_title')->nullable();
            $table->string('page_slug')->nullable();
            $table->text('page_content')->nullable();

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
        // drop table
        Schema::drop('pages');
    }
}
