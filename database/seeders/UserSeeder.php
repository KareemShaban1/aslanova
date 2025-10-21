<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'fname' => 'user 1',
            'lname' => 'last name',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('password'),
            'location' => 'location 1',
            'phoneNumber' => '1234567890',
            'notes' => 'notes 1',
        ]);
    }
}
