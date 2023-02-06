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
    public function test_redireciona_inicio_usuario_nao_autenticado()
    {       
        $this->get('/empresa/venda')->assertRedirect('/');
        $this->get('/empresa/dashboard')->assertRedirect('/');
        $this->get('/empresa/register/admin')->assertRedirect('/');
        $this->get('/empresa/verify-email')->assertRedirect('/');
        $this->get('/empresa/verify-email/{id}/{hash}')->assertRedirect('/');
        $this->get('/empresa/confirm-password')->assertRedirect('/');

        $this->post('/empresa/venda')->assertRedirect('/');
        $this->post('/empresa/confirm-password')->assertRedirect('/');
        $this->post('/empresa/email/verification-notification')->assertRedirect('/');
        $this->post('/empresa/logout')->assertRedirect('/');       

    }
    public function test_empresa_realiza_venda()
    {   
                
        $empresa = Empresa::factory()->create();                
        $this->actingAs($empresa,'empresa');  
               
        $this->assertAuthenticated('empresa');     
        $resposta = $this->post('/empresa/venda',['valor'=>50]); 
    
        $this->assertEquals(50, Empresa::where('cnpj', '=', $empresa->cnpj)->first()->saldo_empresa); 
        $resposta->assertRedirect(RouteServiceProvider::EMPRESA_HOME);       
        
        $this->refreshDatabase();
        
    }
    
    public function test_empresa_adiciona_admin()
    {
        $dados = [
            'cnpj' => '45678901234567',
            'razao' => 'Bahia ltda',
            'nomeFantasia' => 'Papelaria Bahia',
            'cpf_admin' => null,
            'telefone' => '75988562669',            
            'email' => 'php@gmail.com',
            'password' => '12345678', 
            'password_confirmation' => '12345678',
        ];   
        $empresa = Empresa::factory()->state($dados)->make();

        $user = User::factory()->make();  
        $this->actingAs($empresa,'empresa');
        $this->post('/register', [
            'name'=> $user->name,
            'surname'=> $user->surname,
            'cpf'=> $user->cpf,
            'email'=> $user->email,
            'email_confirmation'=> $user->email,
            'password'=> '12345678',
            'password_confirmation'=> '12345678',
                        
        ])->assertSessionDoesntHaveErrors();
        $resposta = $this->call('POST', route('register', $user));
        $this->assertNotNull(User::where('cnpj_empresa', '=', $empresa->cnpj)->first());
        $this->refreshDatabase();
    }

    
    public function test_empresa_retorna_index()
    {
        $empresa = Empresa::factory()->create();                
        $this->actingAs($empresa,'empresa'); 
        $this->assertAuthenticated('empresa');
        $this->get('/empresa/dashboard')->assertSessionDoesntHaveErrors();
                
    }
}
