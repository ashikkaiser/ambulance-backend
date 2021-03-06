<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(AdminUserSeeder::class);
        $this->call(DistrictSeeder::class);
        //$this->call(PartnerSeeder::class);
        //$this->call(ModeratorSeeder::class);
        //$this->call(AgentSeeder::class);
    }
}
