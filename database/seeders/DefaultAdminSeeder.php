<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $faker = \Faker\Factory::create();
        $password = Hash::make('glover1234');

        for ($i=0; $i < 2; $i++) {
            $user = User::create([
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => "admin0{$i}@sample.test",
                'password' => $password
            ]);

            $user->assignRole('admin');
        }

    }
}
