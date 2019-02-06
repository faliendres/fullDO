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
            $table->increments('id_cargo');
            $table->string('nombre', 128)->nullable();
            $table->string('descripcion', 512)->nullable();
            $table->integer('id_empresa')->unsigned()->nullable();
            $table->string('area', 256)->nullable();
            $table->integer('id_funcionario')->unsigned()->nullable();
            $table->integer('id_jefatura')->unsigned()->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->string('color', 32)->nullable();
            $table->integer('estado')->default(1);
        });
        Schema::table('ma_cargo', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('ma_empresa')->onDelete('cascade');
            $table->foreign('id_funcionario')->references('id_funcionario')->on('ma_funcionario')->onDelete('cascade');
            $table->foreign('id_jefatura')->references('id_gerencia')->on('ma_gerencia')->onDelete('cascade');

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
