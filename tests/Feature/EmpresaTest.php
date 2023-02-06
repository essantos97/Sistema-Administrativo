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
    /**
     * Teste simples para verificar se a tela de login pode ser renderizada 
     * mesmo que você seja um visitante, para testar se os middlewares estão
     * corretos.
     *
     * @return void
     */
    public function test_janela_login_pode_ser_renderizada()
    {
        $response = $this->get('/empresa/login');
        $this->assertGuest();
        $response->assertStatus(200);
    }
    /**
     * Teste para verificar se os middlewares estão funcionando corretamente, 
     * redirecionando para a tela inicial do sistema, usuários que não tem a 
     * devida permissão para acessar as rotas da empresa, que necessitam de 
     * autenticação.
     *
     * @return void
     */
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
    /**
     * Teste para verificar se a rota e o método de de adicionar venda estão 
     * funcionando corretamente, uma vez que apenas empresas autenticadas podem 
     * realizar essa operação.
     *
     * @return void
     */
    public function test_empresa_realiza_venda()
    {   
                
        $empresa = Empresa::factory()->create();                
        $this->actingAs($empresa,'empresa');  
               
        $this->assertAuthenticated('empresa');     
        $resposta = $this->post('/empresa/venda',['valor'=>50])->assertSessionDoesntHaveErrors(); 
    
        $this->assertEquals(50, Empresa::where('cnpj', '=', $empresa->cnpj)->first()->saldo_empresa); 
        $resposta->assertRedirect(RouteServiceProvider::EMPRESA_HOME);       
        
        $this->refreshDatabase();
        
    }
    /**
     * Teste para verificar se as rotas e o método de adicionar admin estão corretos.
     *
     * @return void
     */
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
    /**
     * Teste para verificar se a rota que retorna a empresa para o index da 
     * empresa está correta e se está retornando sem erros.
     *
     * @return void
     */
    public function test_empresa_retorna_index()
    {
        $empresa = Empresa::factory()->create();                
        $this->actingAs($empresa,'empresa'); 
        $this->assertAuthenticated('empresa');
        $this->get('/empresa/dashboard')->assertSessionDoesntHaveErrors();
                
    }
}
