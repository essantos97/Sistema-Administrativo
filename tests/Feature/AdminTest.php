<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminController;
use App\Models\Conta;
use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_redireciona_login_usuario_nao_autenticado_acessando_rotas_admin()
    {
        $this->get('/confirm-password')->assertRedirect('/');
        $this->get('/verify-email/{id}/{hash}')->assertRedirect('/');
        $this->get('/verify-email')->assertRedirect('/');
        $this->get('/admin/saque')->assertRedirect('/');
        $this->get('/admin/adicionar/conta')->assertRedirect('/');
        $this->get('/admin/verificar/conta')->assertRedirect('/');
        $this->get('/dashboard')->assertRedirect('/');
        $this->get('/register')->assertRedirect('/');
     
        $this->post('/register')->assertRedirect('/');
        $this->post('/logout')->assertRedirect('/');
        $this->post('/email/verification-notification')->assertRedirect('/');
        $this->post('/confirm-password')->assertRedirect('/');
        $this->post('/admin/saque')->assertRedirect('/');
        $this->post('/admin/adicionar/conta')->assertRedirect('/');
        $this->post('/admin/verificar/conta')->assertRedirect('/');        
    }

    public function test_admin_adiciona_conta()
    {                       
        $user = User::factory()->create();
        $this->actingAs($user); 
        $this->assertAuthenticated('web'); 
        $resposta = $this->post('/admin/adicionar/conta', [
            'num_conta' => '18796592', 
            'proprietario' => 'Bruno Magnata'
        ])->assertSessionDoesntHaveErrors();
        
        $this->assertNotNull(Conta::where('num_conta', '=', 18796592)->first());
        $resposta->assertRedirect(RouteServiceProvider::HOME); 
        $this->refreshDatabase();         
    }

    public function test_admin_nao_preenche_campos_para_adicionar_conta(){
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated('web');
        $this->post('/admin/adicionar/conta')->assertSessionHasErrors([
            'num_conta'=>'O número da conta é obrigatório.',
            'proprietario'=>'O nome do proprietário da conta é obrigatório'
        ]);

        $this->post('/admin/adicionar/conta',['num_conta'=>123456789])->assertSessionHasErrors([            
            'proprietario'=>'O nome do proprietário da conta é obrigatório'
        ]);

        $this->post('/admin/adicionar/conta',['proprietario'=>'Samba do Polly'])->assertSessionHasErrors([            
            'num_conta'=>'O número da conta é obrigatório.'
        ]);
        $this->post('/admin/adicionar/conta',[
            'proprietario'=>'Samba do Polly', 
            'num_conta' => 'jkuhg'])->assertSessionHasErrors([

            'num_conta'=>'O número da conta é totalmente numérico.'
        ]);
        $this->post('/admin/adicionar/conta',[
            'proprietario'=>'Samba do Polly', 
            'num_conta'=>123456789,
        ])->assertRedirect(RouteServiceProvider::HOME);

        $this->assertNotNull(Conta::where('num_conta','=', 123456789)->first());

        $this->post('/admin/adicionar/conta',[
            'proprietario'=>'Samba do Polly', 
            'num_conta'=>123456789,
        ])->assertSessionHasErrors(['num_conta'=>'Esta conta já está no sistema.']);
        
        $this->refreshDatabase();
    
    }

    public function test_admin_verifica_conta()
    {
        $user = User::factory()->create();
        $this->actingAs($user); 
        $this->assertAuthenticated('web');
        $this->post('/admin/adicionar/conta', [
            'num_conta' => '18796592', 
            'proprietario' => 'Hiago Danadinho'
        ]);
        $this->assertEquals(null, Conta::where('num_conta', '=', 18796592)->first()->verificada);
        $this->post('/admin/verificar/conta',['num_conta' =>'18796592'])->assertRedirect('/dashboard');

        $this->assertEquals(true, Conta::where('num_conta', '=', 18796592)->first()->verificada);   
        $this->post('/logout');
    }
    public function test_admin_nao_preenche_dados_para_verificar_conta()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticated('web');
        $this->post('/admin/adicionar/conta', [
            'num_conta' => 123456, 
            'proprietario' => 'Ivete Sangalo'
        ])->assertSessionDoesntHaveErrors();

        $this->post('/admin/verificar/conta')->assertSessionHasErrors([
            'num_conta'=>'O número da conta é obrigatório'           
        ]);

        $this->post('/admin/verificar/conta',['num_conta'=>'Polly'])->assertSessionHasErrors([            
            'num_conta'=>'O número da conta é totalmente numérico.'
        ]);
        $this->post('/admin/verificar/conta',[
            'num_conta' => 123456, 
        ])->assertSessionDoesntHaveErrors();                
        

        $this->refreshDatabase();
    }
    
    public function test_admin_realiza_saque()
    {
        
        $empresa = Empresa::factory()->state(['saldo_empresa'=>50])->create();          
        $user = User::where('cnpj_empresa', '=', $empresa->cnpj)->first();
        Empresa::where('cnpj', '=', $user->cnpj_empresa)->update(['cpf_admin'=>$user->cpf]);
        $this->assertNotNull($user);               
        
        $this->assertEquals(50, Empresa::where('cnpj', '=', $empresa->cnpj)->first()->saldo_empresa);       
        $this->assertEquals($user->cpf, Empresa::where('cnpj', '=', $empresa->cnpj)->first()->cpf_admin);
        $this->actingAs($user, 'web'); 
        $this->assertAuthenticated('web'); 
       
        $this->post('/admin/saque', ['num_conta'=>18796592, 'valor' => 10])->assertRedirect(RouteServiceProvider::HOME);
        
    }

    public function test_erros_na_solicitacao_de_saque(){
        $empresa = Empresa::factory()->state(['saldo_empresa'=>50])->create();          
        $user = User::where('cnpj_empresa', '=', $empresa->cnpj)->first();
        Empresa::where('cnpj', '=', $user->cnpj_empresa)->update(['cpf_admin'=>$user->cpf]);
        $this->actingAs($user, 'web');

        $this->post('/admin/saque')->assertSessionHasErrors([
            'num_conta'=>'O número da conta é obrigatório.',
            'valor'=>'O valor do saque é obrigatório.',
        ]); 

        $this->post('/admin/saque',['num_conta' => 187796592])->assertSessionHasErrors([            
            'valor'=>'O valor do saque é obrigatório.',
        ]);
        
        $this->post('/admin/saque',[
            'num_conta' => 'kj15h2g', 
            'valor'=>'drfs'
        ])->assertSessionHasErrors([            
            'num_conta'=>'O número da conta é totalmente numérico.',
            'valor'=>'O valor deve ser numérico.', 
        ]); 
        
    }
    
}
