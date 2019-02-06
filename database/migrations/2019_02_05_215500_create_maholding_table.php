<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaholdingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_holding', function (Blueprint $table) {
            $table->increments('id_holding');
            $table->string('nombre', 256)->nullable();
            $table->string('descripcion', 512)->nullable();
            $table->string('logo', 256)->nullable();
            $table->string('color', 32)->nullable();
            $table->integer('estado')->default(1);
            $table->date('fecha_creacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_holding');
    }
}
