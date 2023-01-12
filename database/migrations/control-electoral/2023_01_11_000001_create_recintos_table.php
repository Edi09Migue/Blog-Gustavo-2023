<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecintosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('recintos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('canton_id');
            $table->foreign('canton_id')->references('id')->on('cantones'); 
            // $table->unsignedBigInteger('parroquia_id');
            // $table->foreign('parroquia_id')->references('id')->on('parroquias'); 
            $table->string('parroquia');
            $table->string('zonificacion')->nullable();
            $table->enum('tipo', ["R","U"]);
            $table->integer('zona');
            $table->integer('codigo')->unique();
            $table->string('nombre')->unique();
            $table->string('direccion');
            $table->integer('telefono');
            $table->integer('juntas_femeninas');
            $table->integer('juntas_masculinas');
            $table->integer('total_juntas');
            $table->integer('cantidad_electores');
            $table->boolean('cda');
            $table->string('cda_destino')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('recintos');
  
    }
}
