<?php

use Illuminate\Database\Seeder;
use App\Models\StoresUsers;

class StoresUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores_users')->delete();

        StoresUsers::create([
            'store_id' => 1,
            'user_id' => 1]);
    }
}
