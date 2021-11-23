<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Fabiana G',
            'email' => 'fabiana@email.com',
            'cpf_cnpj' => '12345678900',
            'password' => md5('1234'),
            'shopkeeper' => false
        ]);

        User::create([
            'id' => 2,
            'name' => 'Zelda TLZ',
            'email' => 'zelda@email.com',
            'cpf_cnpj' => '22222222222',
            'password' => md5('2222'),
            'shopkeeper' => true
        ]);
    }
}
