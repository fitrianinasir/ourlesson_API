<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('nis',30)->unique();
            $table->string('student_name');
            $table->string('birthplace');
            $table->string('birthdate');
            $table->string('address');
            $table->string('religion');
            $table->string('schools');
            $table->string('gender');
            $table->string('email', 30)->unique();
            $table->integer('phone_number');
            $table->integer('year');
            $table->string('student_class');
            $table->string('image');
            $table->string('password');
            $table->timestamp('nis_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
