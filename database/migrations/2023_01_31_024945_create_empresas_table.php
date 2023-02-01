<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('cnpj')->unique();
            $table->string('cpf_admin')->nullable();
            $table->foreign('cpf_admin')->references('cpf')->on('users');
            $table->string('razao');
            $table->string('nomeFantasia');
            $table->double('saldo_empresa');            
            $table->string('telefone');
            $table->string('permissao');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); 
            $table->string('password');           
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
        Schema::dropIfExists('empresas');
    }
}
