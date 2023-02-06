<?php

namespace Database\Factories;

use App\Models\Conta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }
    public function definition()
    {
        return [
            'num_conta' => $this->faker->unique()->rg(false),
            'proprietario' => $this->faker->name,
            'verificada' => $this->faker->boolean(),
            'saldo' => 0,
            'cpf_admin' => $this->faker->cpf(false),
        ];
    }
}
