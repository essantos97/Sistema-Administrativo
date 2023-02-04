<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpresaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_janela_login_pode_ser_renderizada()
    {
        # code...
    }
    public function test_redireciona_login_usuario_nao_autenticado()
    {
        # code...
    }
    public function test_empresa_realiza_venda()
    {
        # code...
    }
    public function test_empresa_adiciona_admin()
    {
        # code...
    }
    public function test_empresa_retorna_index()
    {
        # code...
    }
}
