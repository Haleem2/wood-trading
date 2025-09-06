<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::first();

        $users = [
            [
                'name' => 'John Admin',
                'email' => 'admin@woodtrading.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0100',
                'tenant_id' => $tenant->id,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Sales',
                'email' => 'sarah@woodtrading.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0101',
                'tenant_id' => $tenant->id,
                'is_active' => true,
            ],
            [
                'name' => 'Mike Storekeeper',
                'email' => 'mike@woodtrading.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0102',
                'tenant_id' => $tenant->id,
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Accountant',
                'email' => 'lisa@woodtrading.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0103',
                'tenant_id' => $tenant->id,
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            // Assign roles based on email
            switch ($user->email) {
                case 'admin@woodtrading.com':
                    $user->assignRole('Owner/Admin');
                    break;
                case 'sarah@woodtrading.com':
                    $user->assignRole('Salesperson');
                    break;
                case 'mike@woodtrading.com':
                    $user->assignRole('Storekeeper');
                    break;
                case 'lisa@woodtrading.com':
                    $user->assignRole('Accountant');
                    break;
            }
        }
    }
}
