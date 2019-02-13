<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_cargo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 128)->nullable();
            $table->string('descripcion', 512)->nullable();
            $table->integer('id_gerencia')->unsigned()->nullable();
            $table->string('area', 256)->nullable();
            $table->integer('id_funcionario')->unsigned()->nullable();
            $table->integer('id_jefatura')->unsigned()->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->string('color', 32)->nullable();
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
        Schema::table('ma_cargo', function (Blueprint $table) {
            $table->foreign('id_gerencia')->references('id')->on('ma_gerencia');//->onDelete('cascade');
            $table->foreign('id_funcionario')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('id_jefatura')->references('id')->on('ma_cargo');//->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_cargo');
    }
}
