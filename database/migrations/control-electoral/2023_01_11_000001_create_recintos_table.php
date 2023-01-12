<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
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
            $table->string('nombre')->unique();

            $table->unsignedBigInteger('tipo_receta_id');
            $table->foreign('tipo_receta_id')->references('id')->on('tipos_recetas'); 

            $table->enum('dificultad', ["facil","medio","dificil"])->nullable();
            $table->integer('cocinanda_por')->nullable();
            $table->integer('porciones')->nullable();
            $table->string('tiempo')->nullable();
            
            $table->text('descripcion');

            $table->boolean('destacada')->default(false);

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
        Schema::dropIfExists('recetas');
  
    }
}
