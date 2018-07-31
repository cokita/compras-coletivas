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
    }

}
