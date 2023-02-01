<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empresa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cnpj' => $this->faker->unique()->cnpj,
            'cpf_admin' => $this->faker->cpf,
            'saldo_empresa' => 0,
            'razao' => $this->faker->razao,
            'nomeFantasia' => $this->faker->nomeFantasia,
            'telefone' => $this->faker->telefone,
            'permissao' => 'usuario',
            'email' => $this->faker->unique()->safeEmail,                
            'password' => bcrypt(12345678),
        ];
    }
}
