<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemperatureTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
      Schema::create('temperature', function (Blueprint $table) {
        $table->increments('id');
        $table->string('temperature');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
         Schema::drop('temperature');
    }
}
