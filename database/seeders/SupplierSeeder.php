<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Premium Timber Co.',
                'contact_person' => 'Robert Supplier',
                'email' => 'robert@premiumtimber.com',
                'phone' => '+1-555-1000',
                'address' => '100 Timber Street, Forest City, FC 10000',
                'tax_id' => 'TAX001',
                'payment_terms' => 'Net 30',
                'lead_time_days' => 7,
                'credit_limit' => 50000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Quality Woods Ltd.',
                'contact_person' => 'Maria Woods',
                'email' => 'maria@qualitywoods.com',
                'phone' => '+1-555-1001',
                'address' => '200 Oak Avenue, Woodland, WL 20000',
                'tax_id' => 'TAX002',
                'payment_terms' => 'Net 15',
                'lead_time_days' => 5,
                'credit_limit' => 75000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Forest Products Inc.',
                'contact_person' => 'David Forest',
                'email' => 'david@forestproducts.com',
                'phone' => '+1-555-1002',
                'address' => '300 Pine Road, Mountain View, MV 30000',
                'tax_id' => 'TAX003',
                'payment_terms' => 'Net 45',
                'lead_time_days' => 10,
                'credit_limit' => 100000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Budget Lumber Co.',
                'contact_person' => 'Susan Budget',
                'email' => 'susan@budgetlumber.com',
                'phone' => '+1-555-1003',
                'address' => '400 Cheap Street, Economy Town, ET 40000',
                'tax_id' => 'TAX004',
                'payment_terms' => 'Cash on Delivery',
                'lead_time_days' => 3,
                'credit_limit' => 25000.00,
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
