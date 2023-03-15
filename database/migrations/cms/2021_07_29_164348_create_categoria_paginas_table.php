<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaPaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_paginas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pagina_id');
            $table->foreign('pagina_id')->references('id')-> on('paginas')->onDelete('cascade'); 
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')-> on('categorias_blog')->onDelete('cascade'); 
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
        Schema::dropIfExists('categoria_paginas');
    }
}
