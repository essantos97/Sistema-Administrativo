<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Altera o faker para criação de dados em português e adiciona dados específicos do Brasil.
     *
     * @return object factoty
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    
    public function definition()
    {
        return [            
            'name' => $this->faker->firstname,
            'surname' => $this->faker->lastname,
            'cpf' => $this->faker->unique()->cpf(false),            
            'cnpj_empresa' => $this->faker->unique()->cnpj(false),                
            'email' => $this->faker->unique()->safeEmail,
            'permissao' => 'admin',
            'password' => bcrypt(12345678),            
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
