<?php

namespace Database\Seeders;

use App\Models\Conta;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Preenche o banco de dados com as seeds, só é necessário informar 
     * quantas empresas serão criadas, uma vez que no método configure 
     * da factory de empresa é feito a criação do usuário(administrador).
     *
     * @return void
     */
    public function run()
    {         
        Empresa::factory()->count(20)->create();
        Conta::factory()->count(10)->create();
        
    }
}
