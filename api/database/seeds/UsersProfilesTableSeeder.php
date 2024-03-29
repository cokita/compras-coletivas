<?php

use Illuminate\Database\Seeder;
use App\Models\UsersProfiles;

class UsersProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_profiles')->delete();

        UsersProfiles::create(['user_id' => 1, 'profile_id' => 1]);
        UsersProfiles::create(['user_id' => 2, 'profile_id' => 3]);
        UsersProfiles::create(['user_id' => 3, 'profile_id' => 2]);
    }
}
