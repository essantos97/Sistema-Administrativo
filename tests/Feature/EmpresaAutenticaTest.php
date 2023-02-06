<?php

namespace Tests\Feature;

use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpresaAutenticaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Teste feito para verificar se a empresa consegue fazer login pela
     * rota de autenticação.
     *
     * @return void
     */
    
    public function test_empresa_can_authenticate_using_the_login_screen()
    {        
        $this->refreshDatabase();
        $empresa = Empresa::factory()->create();        
        $response = $this->post('/empresa/login', [
            'email' => $empresa->email,
            'password' => '12345678',
        ])->assertSessionDoesntHaveErrors();
        $this->assertAuthenticated('empresa');    
                               
        $this->refreshDatabase();
    }
    /**
     * Teste para mostrar que a empresa não consegue fazer login com senha
     *  inválida e também que foram recebidos erros.
     *
     * @return void
     */
    public function test_empresa_can_not_authenticate_with_invalid_password()
    {
        $empresa = Empresa::factory()->create();

        $this->post('/empresa/login', [
            'email' => $empresa->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors();

        $this->assertGuest();
        $this->refreshDatabase();
    }
    /**
     * Teste feito para mostrar as mensagens que a empresa 
     * receberia ao tentar fazer login sem preencher os dados.
     *
     * @return void
     */
    public function test_usuario_nao_passa_credenciais(){
        $empresa = Empresa::factory()->create();

        $this->post('/empresa/login')->assertSessionHasErrors([
            'email'=>'The email field is required.',
             'password'=>'The password field is required.'
        ]);
        $this->assertGuest();
            
    }
}
