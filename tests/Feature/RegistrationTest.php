<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertRedirect('/');        
    }

    public function test_new_users_can_register()
    {        
        $this->post('/register', [
            'name' => 'Test',
            'surname' => 'User',
            'cpf' => '03369165306',                        
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ])->assertSessionDoesntHaveErrors();
              
        $this->refreshDatabase();
    }

    public function test_novos_usuarios_nao_preenchem_dados_de_registro()
    {        
        $this->post('/register')->assertSessionHasErrors([
            'name'=>'O nome é obrigatório.',
            'surname'=>'O sobrenome é obrigatório',            
            'cpf' => 'O CPF é obrigatório para cadastro.',            
            'password' => 'A senha é obrigatória, digite a senha.',                        
            'email' => 'O email é necessário para cadastro.',                        
        ]);       
                      
    }

}
