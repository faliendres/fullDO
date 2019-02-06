<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMausuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ma_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rut', 12)->nullable();
            $table->string('nombre', 128)->nullable();
            $table->string('apellido', 128)->nullable();
            $table->string('mail', 64)->unique();
            $table->string('contrasena', 32)->nullable();
            $table->integer('perfil')->nullable();
            $table->date('fecha_creacion')->useCurrent();
            $table->integer('usuario_creacion')->nullable();
            $table->integer('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ma_usuario');
    }
}
