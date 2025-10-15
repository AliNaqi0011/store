<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::create([
            'name' => 'Ali Admin',
            'email' => 'ali@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'permissions' => [
                'dashboard.view',
                'products.view', 'products.create', 'products.edit', 'products.delete',
                'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
                'orders.view', 'orders.edit', 'orders.delete',
                'users.view', 'users.create', 'users.edit', 'users.delete',
                'settings.view', 'settings.edit',
                'reports.view',
                'admins.view', 'admins.create', 'admins.edit', 'admins.delete'
            ],
            'is_active' => true,
        ]);
    }
}