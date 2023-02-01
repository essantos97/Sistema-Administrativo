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
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [            
            'name' => $this->faker->name,
            'surname' => $this->faker->surname,
            'cpf' => $this->faker->unique()->cpf,            
            'cnpj_empresa' => $this->faker->cnpj,                
            'email' => $this->faker->unique()->safeEmail,
            'permissao' => 'admin',
            'password' => bcrypt(12345678),            
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
