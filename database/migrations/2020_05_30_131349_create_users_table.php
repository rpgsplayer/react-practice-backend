<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');   
            $table->string('first_name', 20);   
            $table->string('last_name', 20);   
            $table->string('gender', 6);   
            $table->string('email', 50);   
            $table->date('dob');   
            $table->text('address');   
            $table->string('phone_no', 20);   
            $table->string('occupation', 25);   
            $table->string('password', 100);   
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
        Schema::dropIfExists('users');
    }
}
