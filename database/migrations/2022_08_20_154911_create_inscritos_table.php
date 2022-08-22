<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscritos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('ciudad');
            $table->string('parroquia');
            

            $table->bigInteger('candidato_id')->unsigned();
            $table->foreign('candidato_id')->references('id')->on('users')
            ->onDelete('cascade');

            $table->bigInteger('creado_por')->unsigned();
            $table->foreign('creado_por')->references('id')->on('users')
            ->onDelete('cascade');

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
        Schema::dropIfExists('inscritos');
    }
}
