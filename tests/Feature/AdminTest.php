<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    
    public function test_janela_login_pode_ser_renderizada()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_redireciona_login_usuario_nao_autenticado()
    {
        # code...
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
