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
    
    /**
     * Teste para verificar se novos usuários(admin) podem ser registrados.
     * Como a rota é protegida pelo middleware 'empresa' é necessário autenticar
     *  uma empresa para continuar com a operação.
     *
     * @return void
     */
    public function test_new_users_can_register()
    {        
        $empresa = Empresa::factory()->create();
        $this->actingAs($empresa, 'empresa');
        $this->post('/register', [
            'name' => 'Test',
            'surname' => 'User',
            'cpf' => '03369165306',                        
            'email' => 'test@example.com',
            'email_confirmation' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ])->assertSessionDoesntHaveErrors();
              
        $this->refreshDatabase();
    }
    /**
     * Teste para mostrar as mensagens que o usuário receberia ao tentar 
     * se cadastrar sem preencher os dados do formulário.
     *
     * @return void
     */
    public function test_novos_usuarios_nao_preenchem_dados_de_registro()
    {        
        $empresa = Empresa::factory()->create();
        $this->actingAs($empresa, 'empresa');
        $this->post('/register')->assertSessionHasErrors([                                    
            'name'=>'O nome é obrigatório.',
            'surname'=>'O sobrenome é obrigatório',            
            'cpf' => 'O CPF é obrigatório para cadastro.',         
            'password' => 'A senha é obrigatória, digite a senha.',                        
            'email' => 'O email é necessário para cadastro.',
                     
        ]);   
        
        $this->post('/register', [
            'name' => 'Test',
            'surname' => 'User',
            'cpf' => '03369',                        
            'email' => 'test@exaample.com',
            'email_confirmation' => 'test@example.com',
            'password' => '12345',
            'password_confirmation' => '1234',
        ])->assertSessionHasErrors([                                    
                       
            'cpf' => 'O cpf requer 11 números, digite apenas os números.',         
            'password' => 'A senha deverá ter no mínimo 6 caracteres.',
            'password' => 'As senhas diferem, digite senhas iguais.',                       
            'email' => 'Os emails diferem, digite emails iguais.',                     
        ]);                    
                      
    }

}
