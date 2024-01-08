<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ])

         \App\Models\Role::create([
             'role' => 'admim',
         ]);

        \App\Models\Role::create([
            'role' => 'user',
        ]);

        \App\Models\Permission::create([
            'permission' => 'add_user',
        ]);

        \App\Models\Permission::create([
            'permission' => 'view_user',
        ]);

    }
}
