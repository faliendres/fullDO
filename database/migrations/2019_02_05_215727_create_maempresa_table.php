<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaempresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_empresa', function (Blueprint $table) {
                $table->increments('id_empresa');
                $table->string('nombre', 256)->nullable();
                $table->string('rut', 12)->nullable();
                $table->string('descripcion', 512)->nullable();
                $table->string('logo', 256)->nullable();
                $table->string('color', 32)->nullable();
                $table->integer('id_holding')->unsigned()->nullable();
                $table->date('desde')->nullable();
                $table->date('hasta')->nullable();
                $table->date('fecha_creacion')->nullable();
                $table->integer('estado')->unsigned()->default(1);
                $table->foreign('id_holding')->references('id_holding')->on('ma_holding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_empresa');
    }
}
