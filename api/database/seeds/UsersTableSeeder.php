.<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['email' => 'cokitabr@gmail.com', 
                      'name' => 'Ana Flávia Carvalho', 
                      'password' => bcrypt('abcd1234'), 
                      'cellphone' => '61996170178', 
                      'cpf' => '00331948150',
                      'gender' => 'F']);

        User::create(['email' => 'andrevini@gmail.com',
            'name' => 'André Vincius da Silva Caixeta',
            'password' => bcrypt('abcd1234'),
            'cellphone' => '61998280155',
            'cpf' => '00713877146',
            'gender' => 'M']);

        User::create(['email' => 'gigiovana.caixeta@gmail.com',
            'name' => 'Giovana Araújo Carvalho da Silva Caixeta',
            'password' => bcrypt('abcd1234'),
            'cellphone' => '61999141905',
            'cpf' => '30326160183',
            'gender' => 'F']);
    }

}
