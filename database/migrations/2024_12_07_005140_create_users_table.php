<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique()->nullable(); 
            $table->string('identification')->unique()->nullable(); 
            $table->dateTime('birthdate')->nullable(); 
            $table->string('role')->nullable(); 
            $table->text('address')->nullable(); 
            $table->boolean('termsAndConditions')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
