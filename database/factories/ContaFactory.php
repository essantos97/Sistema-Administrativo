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
    public function definition()
    {
        return [
            'num_conta'=> $this->faker->rand(1, 9999999999),
            'proprietario'=> $this->faker->name(),
            'verificada'=> $this->faker->rand(false, true),
            'saldo'=>0,
        ];
    }
}
