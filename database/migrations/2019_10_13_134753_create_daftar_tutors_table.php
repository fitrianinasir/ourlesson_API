<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_tutors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tutor_name');
            $table->string('tutor_subject');
            $table->string('background');
            $table->integer('phone_number');
            $table->string('email', 30)->unique();
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
        Schema::dropIfExists('daftar_tutors');
    }
}
