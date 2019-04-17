<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnDescripcionInMaCargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ma_cargo', function (Blueprint $table) {
            $table->dropColumn('descripcion'); // then column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ma_cargo', function (Blueprint $table) {
            $table->string('descripcion', 512)->nullable()->after('nombre');
        });
    }
}