<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaralangTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralang_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translator');
            $table->text('string');
            $table->string('from_lang');
            $table->string('to_lang');
            $table->text('translation');
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
        Schema::dropIfExists('laralang_translations');
    }
}
