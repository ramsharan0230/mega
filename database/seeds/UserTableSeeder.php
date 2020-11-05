<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'One Up',
                'email' => 'info@mega.com',
                'password' => bcrypt('oneup@123mega'),
                'role' => 'super-admin',
                'publish' => 1,
            ],

            [
                'name' => 'Web House Admin',
                'email' => 'info@user.com',
                'password' => bcrypt('secret'),
                'role' => 'super-admin',
                'publish' => 1,
            ],
        ];

        User::insert($user);
    }
}
