<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('apellido')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('rut', 12)->nullable();
            $table->string('password');
            $table->integer('perfil')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('usuario_creacion')->nullable();
            $table->integer('telefono')->nullable();
            $table->string('foto', 256)->nullable();
            $table->integer('estado')->default(1);
            $table->unsignedInteger('gerencia_id')->nullable();
            $table->unsignedInteger('empresa_id')->nullable();
            $table->unsignedInteger('holding_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
