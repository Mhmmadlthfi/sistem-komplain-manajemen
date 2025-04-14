<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'no_staff' => '01001',
                'name' => 'Bang Manager Marketing',
                'telp' => '089385738654',
                'email' => 'managermarketing@gmail.com',
                'role' => 'manager_marketing',
                'password' => bcrypt('managermarketing')
            ],
            [
                'no_staff' => '02001',
                'name' => 'Bang Aftersales',
                'telp' => '089385738231',
                'email' => 'aftersales@gmail.com',
                'role' => 'aftersales',
                'password' => bcrypt('aftersales')
            ],
            [
                'no_staff' => '03001',
                'name' => 'Bang Marketing',
                'telp' => '089385738321',
                'email' => 'marketing@gmail.com',
                'role' => 'marketing',
                'password' => bcrypt('marketing')
            ],
            [
                'no_staff' => '04001',
                'name' => 'Bang Teknisi',
                'telp' => '089385738987',
                'email' => 'teknisi@gmail.com',
                'role' => 'teknisi',
                'password' => bcrypt('teknisi')
            ],
            [
                'no_staff' => '04002',
                'name' => 'Bang Teknisi 2',
                'telp' => '085945873987',
                'email' => 'teknisi2@gmail.com',
                'role' => 'teknisi',
                'password' => bcrypt('teknisi2')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
