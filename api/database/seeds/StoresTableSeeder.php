<?php

use Illuminate\Database\Seeder;
use App\Models\Stores;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->delete();

        Stores::create([
            'name' => 'Loja da Ana',
            'user_id' => 1]);
    }
}
