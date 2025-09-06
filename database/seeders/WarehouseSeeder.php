<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouses = [
            [
                'name' => 'Main Warehouse',
                'address' => '123 Industrial Park, Timber City, TC 12345',
                'contact_person' => 'Mike Storekeeper',
                'phone' => '+1-555-0200',
                'email' => 'warehouse@woodtrading.com',
                'is_active' => true,
            ],
            [
                'name' => 'Secondary Storage',
                'address' => '456 Storage Lane, Forest Town, FT 67890',
                'contact_person' => 'Tom Assistant',
                'phone' => '+1-555-0201',
                'email' => 'storage@woodtrading.com',
                'is_active' => true,
            ],
            [
                'name' => 'Seasonal Storage',
                'address' => '789 Winter Road, Cold City, CC 54321',
                'contact_person' => 'Jane Manager',
                'phone' => '+1-555-0202',
                'email' => 'seasonal@woodtrading.com',
                'is_active' => false,
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
