<?php

namespace Tests\Feature;

use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpresaRegistroTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
  
    public function test_empresa_pode_ser_registrada_pela_rota()
    {
        
        $dados = [
            'cnpj' => '45678901234567',
            'razao' => 'Bahia ltda',
            'nomeFantasia' => 'Papelaria Bahia',
            'telefone' => '75988562669',            
            'email' => 'php@gmail.com',
            'password' => '12345678', 
            'password_confirmation' => '12345678',
        ];   
        
        $this->post('/empresa/register', $dados)->assertSessionDoesntHaveErrors();
        $empresa = Empresa::where('cnpj', '=', '45678901234567')->first();
        $this->assertNotEquals(null, $empresa);
        $this->refreshDatabase();

    }
}
