<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->unsignedBigInteger('junta_id');
            $table->foreign('junta_id')->references('id')->on('juntas'); 
            $table->integer('votos_blancos')->default(0);
            $table->integer('votos_nulos')->default(0);
            $table->integer('votos_validos')->default(0);
            $table->unsignedBigInteger('procesado_por');
            $table->boolean('estado')->default(false);
            $table->foreign('procesado_por')->references('id')->on('users');
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
        Schema::dropIfExists('actas');
  
    }
}
