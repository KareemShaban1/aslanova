<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Driver::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $user = Driver::create([
                'fname' => 'admin',
                'lname' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'location' => '-',
                'phoneNumber' => '-',
            ]);
        }
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
