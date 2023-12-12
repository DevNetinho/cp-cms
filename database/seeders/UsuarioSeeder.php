<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //MANIPULAÇÃO DO BD
use Illuminate\Support\Facades\Hash; //CRIPTOGRAFIA DE SENHAS


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //GERAR UM USUÁRIO PADRÃO PARA A UTILIZAÇÃO DO SISTEMA
        DB::table('users')->insert([
            'name' => 'Default User',
            'email' => 'default@default.com',
            'password' => Hash::make('default123')
        ]);
    }
}
