<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReusuarioholdingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_usuario_holding', function (Blueprint $table) {
            $table->unsignedInteger('id_relacion');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_holding');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_gerencia')->nullable();
            $table->integer('tipo_permiso')->nullable();
            $table->primary(['id_relacion', 'id_usuario', 'id_holding']);
        });
        Schema::table('re_usuario_holding', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id')->on('ma_empresa');
            $table->foreign('id_holding')->references('id')->on('ma_holding');
            $table->foreign('id_gerencia')->references('id')->on('ma_gerencia');
            $table->foreign('id_usuario')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_usuario_holding');
    }
}
