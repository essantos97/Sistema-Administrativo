<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpresaTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_janela_login_pode_ser_renderizada()
    {
        $response = $this->get('/empresa/login');

        $response->assertStatus(200);
    }
    public function test_redireciona_login_usuario_nao_autenticado()
    {
       
        $resposta = $this->get('/empresa/venda');
        $resposta->assertRedirect('/');

        $resposta = $this->get('/empresa/dashboard');
        $resposta->assertRedirect('/');

        $resposta = $this->get('/empresa/register/admin');
        $resposta->assertRedirect('/');
        
        
    }
    public function test_empresa_realiza_venda()
    {   
        
        //$this->withoutMiddleware();
        $empresa = Empresa::factory()->create();        
        $resposta = $this->assertDatabaseHas('empresas', ['email'=>$empresa->email]);
        $resposta = $this->actingAs($empresa,'empresa');   
        $this->assertAuthenticated();     
        $resposta = $this->post('/empresa/venda',['valor'=>50]); 
       
        //$resposta->assertRedirect(RouteServiceProvider::EMPRESA_HOME);       
        //$resposta = $this->assertDatabaseHas('empresas', ['saldo_empresa'=>50]); 
        $this->refreshDatabase();
        

    }
    public function test_empresa_adiciona_admin()
    {
        
    }
    public function test_empresa_retorna_index()
    {
        
    }
}
