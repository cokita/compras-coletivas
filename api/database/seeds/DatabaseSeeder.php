<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(ProfilesTableSeeder::class);
         $this->call(UsersProfilesTableSeeder::class);
         $this->call(StoresTableSeeder::class);
         $this->call(StoresUsersTableSeeder::class);
         $this->call(OAuthSeeder::class);
         $this->call(OrderTypeTableSeeder::class);
         $this->call(OrderStatusTableSeeder::class);
    }
}
