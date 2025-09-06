<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = [
            [
                'name' => 'Wood Trading Co.',
                'domain' => 'woodtrading.local',
                'database' => 'wood_trading_main',
                'settings' => [
                    'currency' => 'USD',
                    'timezone' => 'UTC',
                    'date_format' => 'Y-m-d',
                    'company_name' => 'Wood Trading Co.',
                    'company_address' => '123 Wood Street, Timber City, TC 12345',
                    'company_phone' => '+1-555-0123',
                    'company_email' => 'info@woodtrading.com',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Timber Solutions Ltd.',
                'domain' => 'timbersolutions.local',
                'database' => 'timber_solutions_main',
                'settings' => [
                    'currency' => 'EUR',
                    'timezone' => 'Europe/London',
                    'date_format' => 'd/m/Y',
                    'company_name' => 'Timber Solutions Ltd.',
                    'company_address' => '456 Oak Avenue, Forest Town, FT 67890',
                    'company_phone' => '+44-20-7946-0958',
                    'company_email' => 'contact@timbersolutions.co.uk',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($tenants as $tenant) {
            Tenant::create($tenant);
        }
    }
}
