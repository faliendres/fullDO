<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('de_dominio', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('id_valor');
            $table->string('descripcion', 256)->nullable();
            $table->date('fecha_creacion')->nullable();
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
        Schema::dropIfExists('de_dominio');
    }
}
