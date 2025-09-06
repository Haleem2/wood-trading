<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TenantSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            WarehouseSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            ItemSeeder::class,
            StockLotSeeder::class,
        ]);
    }
}
