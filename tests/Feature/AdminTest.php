<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_redireciona_login_usuario_nao_autenticado_acessando_rotas_admin()
    {
        $resposta = $this->get('/dashboard');
        $resposta->assertRedirect('/');
        
        $resposta = $this->get('/admin/verificar/conta');
        $resposta->assertRedirect('/');

        $resposta = $this->get('/admin/adicionar/conta');
        $resposta->assertRedirect('/');

        $resposta = $this->get('/admin/saque');
        $resposta->assertRedirect('/');
    }
    public function test_admin_adiciona_conta()
    {
        $this->withoutMiddleware('web');
        
        Session::start();
        $user = User::factory()->create();
        $this->actingAs($user);  
        $resposta = $this->call('POST', route('admin.adicionar.conta', [
            'num_conta' => '18796592', 
            'proprietario' => 'Bruno Magnata'
        ]));
        
        $resposta->assertRedirect(RouteServiceProvider::HOME);  
        $this->withoutExceptionHandling();  
    }
    public function test_admin_verifica_conta()
    {
        # code...
    }
    public function test_admin_realiza_saque()
    {
        # code...
    }
    
}
