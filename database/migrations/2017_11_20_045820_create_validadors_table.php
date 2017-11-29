<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validadors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address_legal');
            $table->date('birthday');
            $table->string('account_digits');
            $table->string('concept');
            $table->string('bank');
            $table->string('job_position');
            $table->bollean('enabled');
            $table->rememberToken();
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
        Schema::drop('validadors');
    }
}
