<?php

use Illuminate\Database\Seeder;
use App\Models\ProfilesActions;
use Illuminate\Support\Facades\DB;

class ProfilesActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles_actions')->delete();
        DB::select('ALTER TABLE profiles_actions AUTO_INCREMENT = 1');

        ProfilesActions::create(['action_id' => 1, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 1, 'profile_id' => 2]);
        ProfilesActions::create(['action_id' => 1, 'profile_id' => 3]);

        ProfilesActions::create(['action_id' => 2, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 2, 'profile_id' => 2]);

        ProfilesActions::create(['action_id' => 3, 'profile_id' => 1]);

        ProfilesActions::create(['action_id' => 4, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 4, 'profile_id' => 2]);
        ProfilesActions::create(['action_id' => 4, 'profile_id' => 3]);

        ProfilesActions::create(['action_id' => 5, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 5, 'profile_id' => 2]);

        ProfilesActions::create(['action_id' => 5, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 5, 'profile_id' => 2]);

        ProfilesActions::create(['action_id' => 6, 'profile_id' => 1]);
        ProfilesActions::create(['action_id' => 6, 'profile_id' => 2]);

        ProfilesActions::create(['action_id' => 7, 'profile_id' => 2]);
        ProfilesActions::create(['action_id' => 7, 'profile_id' => 1]);

        ProfilesActions::create(['action_id' => 8, 'profile_id' => 1]);

    }
}
