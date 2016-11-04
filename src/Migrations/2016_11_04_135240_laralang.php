<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Laralang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translator')->default('Unknoun');
            $table->string('alias')->unique()->default('Unknoun');
            $table->string('string')->default('Unknoun');
            $table->string('from_lang')->default('Unknoun');
            $table->string('to_lang')->default('Unknoun');
            $table->string('translation')->default('Unknoun');
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
        Schema::dropIfExists('laralang');
    }
}
