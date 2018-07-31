<?php

use Illuminate\Database\Seeder;
use App\Models\Profiles;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->delete();

        Profiles::create(['name' => 'Administrador']);
        Profiles::create(['name' => 'Vendedor']);
        Profiles::create(['name' => 'Usuario']);
    }
}
