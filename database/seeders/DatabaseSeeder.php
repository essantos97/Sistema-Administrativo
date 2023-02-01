<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Preenche o banco de dados com as seeds, é necessario que o número de usuarios 
     * seja menor ou igual ao número de empresas, paga garantir que cada usuário(admin)
     * está associado a uma empresa.
     *
     * @return void
     */
    public function run()
    {
        // Empresa::factory(10)->create();
        // User::factory(10)->create();        
        // Conta::factory(10)->create();
        $this->call(EmpresasTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContasTableSeeder::class);
    }
}
