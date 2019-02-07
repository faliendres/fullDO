<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagerenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_gerencia', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('id_empresa')->unsigned()->nullable();
                $table->string('nombre', 128)->nullable();
                $table->string('descripcion', 512)->nullable();
                $table->string('color', 32)->nullable();
                $table->date('fecha_creacion')->nullable();
                $table->string('usuario_creacion', 20)->nullable();
                $table->integer('estado')->unsigned()->default(1);
                $table->timestamps();
            });
            Schema::table('ma_gerencia', function (Blueprint $table) {
                $table->foreign('id_empresa')->references('id')->on('ma_empresa');
                });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_gerencia');
    }
}
