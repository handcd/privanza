<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_forro')->nullable();
            $table->string('color_forro')->nullable();
            $table->string('nombre_forro')->nullable();
            $table->string('composicion')->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('forros');
    }
}
