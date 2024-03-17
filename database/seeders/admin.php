<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Juzaweb\CMS\Models\User;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create user
        User::factory(1)->create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'is_admin' => 1
            ]
        );
    }
}
