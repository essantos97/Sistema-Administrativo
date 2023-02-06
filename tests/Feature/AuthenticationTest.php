<?php

namespace Tests\Feature;

use App\Models\Empresa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        
        $user = User::factory()->create();        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '12345678',
        ])->assertSessionDoesntHaveErrors();    
                       
        $this->assertAuthenticated('web');
        $this->refreshDatabase();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $this->refreshDatabase();
    }
    public function test_usuario_nao_passa_credenciais(){
        $user = User::factory()->create();

        $this->post('/login')->assertSessionHasErrors([
            'email'=>'The email field is required.',
             'password'=>'The password field is required.'
        ]);
        $this->assertGuest();
            
    }
}
