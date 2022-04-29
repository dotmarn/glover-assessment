<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            "user",
            "admin"
        ];

        foreach ($roles as $key => $role) {
            Role::updateOrCreate([
                'name' => $role
            ]);
        }
    }
}
