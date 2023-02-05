<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
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
        
        $resposta = $this->actingAs($empresa,'empresa');         
        $this->assertAuthenticated();     
        $resposta = $this->post('/empresa/venda',['valor'=>50]); 
    
        $this->assertEquals(50, Empresa::where('cnpj', '=', $empresa->cnpj)->first()->saldo_empresa); 
        $resposta->assertRedirect(RouteServiceProvider::EMPRESA_HOME);       
        
        $this->refreshDatabase();
        
    }
    public function test_empresa_adiciona_admin()
    {
        $empresa = Empresa::factory()->create();  
        $user = User::factory()->create();  
        $this->actingAs($empresa);
        $resposta = $this->call('POST', route('register', $user));
        $this->assertDatabaseHas('users', $user->email);
    }
    public function test_empresa_retorna_index()
    {
        $empresa = Empresa::factory()->create();        
        
        $this->actingAs($empresa,'empresa'); 
        $resposta = $this->call('GET', route('empresa.dashboard'));
       
        $resposta->assertViewIs('empresa.dashboard');
        $this->refreshDatabase();
    }
}
