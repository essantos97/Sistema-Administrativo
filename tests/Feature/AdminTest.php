<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_redireciona_login_usuario_nao_autenticado()
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
        # code...
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
