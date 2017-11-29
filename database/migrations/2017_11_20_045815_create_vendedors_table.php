<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('enabled')->default(1);
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->date('birthday');
            $table->string('address_home');
            $table->string('address_legal')->nullable();
            $table->string('rfc')->nullable();
            $table->string('account_digits')->nullable();
            $table->string('concept')->nullable();
            $table->string('bank')->nullable();
            $table->integer('type');
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
        Schema::drop('vendedors');
    }
}
