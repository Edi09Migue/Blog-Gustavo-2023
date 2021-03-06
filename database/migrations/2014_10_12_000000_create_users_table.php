<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            $table->string('avatar')->nullable();
            $table->string('username')->unique();
            $table->enum('estado',['pendiente','activo','inactivo'])->default('activo');
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_info', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')
            ->onDelete('cascade');
         
            $table->string('empresa')->nullable();
            $table->string('portada')->nullable();

            $table->string('birthdate')->nullable();
            $table->string('telefono')->nullable();
            $table->string('website')->nullable();
            $table->string('idioma')->nullable();
            $table->enum('genero',['male','female'])->nullable();
            $table->string('contact_options')->nullable();
            
            $table->text('bio')->nullable();

            $table->string('pais')->nullable();
            $table->string('provincia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('direccion_principal')->nullable();
            $table->string('direccion_secundaria')->nullable();

            $table->json('social')->nullable();
            
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
        Schema::dropIfExists('user_info');
        Schema::dropIfExists('users');
    }
}
