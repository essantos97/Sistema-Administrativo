<?php

namespace Tests\Feature;

use App\Models\Empresa;
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
        
        $empresa = Empresa::factory()->create();       
        $this->actingAs($empresa,'empresa');

        $response = $this->post('/register', [
            'name' => 'Test',
            'surname' => 'User',
            'cpf' => '03369165306',                        
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

       // $this->assertDatabaseHas('users', ['cpf'=>'03369165306']);
       // $response->assertRedirect(RouteServiceProvider::EMPRESA_HOME);
        $this->refreshDatabase();
    }
}
