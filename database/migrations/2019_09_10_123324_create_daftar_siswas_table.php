<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_siswas', function (Blueprint $table) {
            $table->increments('student_id')->autoIncrement();
            $table->string('nis',30)->unique();
            $table->string('student_name');
            $table->string('birthplace');
            $table->integer('birthdate');
            $table->string('address');
            $table->string('religion');
            $table->string('school');
            $table->string('gender');
            $table->string('email', 30)->unique();
            $table->bigInteger('phone_number');
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
        Schema::dropIfExists('daftar_siswas');
    }
}
