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
            $table->integer('estado')->default(0);
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_info', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')
            ->onDelete('cascade');
         
            $table->string('birthdate')->nullable();
            $table->string('telefono')->nullable();
            $table->string('website')->nullable();
            $table->string('idioma')->nullable();
            $table->enum('genero',['male','female'])->nullable();
            $table->string('contact_options')->nullable();
            $table->string('pais')->nullable();
            $table->json('social')->nullable();
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
