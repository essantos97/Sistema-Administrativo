<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\User;
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
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    /**
     * No método configure está sendo executado após a criação da empresa e adiciona o cpf
     * do admin na sua tabela, e também faz a criação do usuário.
     * 
     * OBS. ESSA SOLUÇÃO DE ENGENHARIA (armengue para alguns) SÓ ESTÁ SENDO UTILIZADA, POIS 
     * O MÉTODO 'HAS' JUNTO COM A MUDANÇA DE ESTADO DE VARIÁVEIS NÃO ESTÁ FUNCIONANDO.
     * ELE TROCA O ORDEM DA CHAVE ESTRANGEIRA E GERA ERRO DE CONSULTA NO BANCO.
     *
     * @return array
     */
    public function configure()
    {
        return $this->afterCreating(function (Empresa $empresa) {               
            $usu = User::factory()->state(['cnpj_empresa'=>$empresa->cnpj])->create();               
            Empresa::where('cnpj', '=', $empresa->cnpj)->update(['cpf_admin' => $usu->cpf]); 
        });
    }
    
    
    public function definition()
    {
        return [
            'cnpj' => $this->faker->unique()->cnpj(false),
            'cpf_admin' => null,
            'saldo_empresa' => 0,
            'razao' => $this->faker->company,
            'nomeFantasia' => $this->faker->word,
            'telefone' => $this->faker->cellphoneNumber(false),
            'permissao' => 'usuario',
            'email' => $this->faker->unique()->safeEmail,                
            'password' => bcrypt(12345678),
        ];
    }
}
