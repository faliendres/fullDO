<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMafuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut', 12)->nullable();
            $table->string('nombre', 128)->nullable();
            $table->string('apellido', 128)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('mail', 128)->nullable();
            $table->integer('telefono')->nullable();
            $table->string('foto', 256)->nullable();
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('ma_funcionario');
    }
}
