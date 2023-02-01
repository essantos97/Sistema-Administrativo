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
            
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('surname');
            $table->string('cpf')->unique();
            $table->string('cnpj_empresa')->unique();
            $table->foreign('cnpj_empresa')->references('cnpj')->on('empresas')->onDelete('cascade');
            $table->string('email')->unique();                        
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('permissao');
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
