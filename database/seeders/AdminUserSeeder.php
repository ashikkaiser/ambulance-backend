<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.com',
                'password' => Hash::make('demoadmin'),
                'user_category' => 'Admin',
                'status' => 'Active'
            ],
            [
                'email' => 'morderator01@gmail.com',
                'password' => Hash::make('demo1234'),
                'user_category' => 'Moderator',
                'status' => 'Active'
            ],
            [
                'email' => 'partner01@gmail.com',
                'password' => Hash::make('demo1234'),
                'user_category' => 'Partner',
                'status' => 'Active'
            ],
            [
                'email' => 'agent01@gmail.com',
                'password' => Hash::make('agent1234'),
                'user_category' => 'Agent',
                'status' => 'Active'
            ],
        ];

        foreach($data as $d) {
            AdminUser::create($d);
        }
    }
}
