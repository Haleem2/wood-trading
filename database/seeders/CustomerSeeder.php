<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => 'Construction Corp.',
                'contact_person' => 'John Builder',
                'email' => 'john@constructioncorp.com',
                'phone' => '+1-555-2000',
                'address' => '500 Build Street, Construction City, CC 50000',
                'tax_id' => 'CUST001',
                'credit_limit' => 100000.00,
                'outstanding_balance' => 15000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Furniture Factory',
                'contact_person' => 'Emma Designer',
                'email' => 'emma@furniturefactory.com',
                'phone' => '+1-555-2001',
                'address' => '600 Design Avenue, Creative Town, CT 60000',
                'tax_id' => 'CUST002',
                'credit_limit' => 75000.00,
                'outstanding_balance' => 8500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Home Depot Store',
                'contact_person' => 'Mark Manager',
                'email' => 'mark@homedepot.com',
                'phone' => '+1-555-2002',
                'address' => '700 Retail Road, Shopping District, SD 70000',
                'tax_id' => 'CUST003',
                'credit_limit' => 200000.00,
                'outstanding_balance' => 45000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Craft Workshop',
                'contact_person' => 'Anna Craftsman',
                'email' => 'anna@craftworkshop.com',
                'phone' => '+1-555-2003',
                'address' => '800 Art Street, Creative Village, CV 80000',
                'tax_id' => 'CUST004',
                'credit_limit' => 25000.00,
                'outstanding_balance' => 3200.00,
                'is_active' => true,
            ],
            [
                'name' => 'Architect Studio',
                'contact_person' => 'Peter Architect',
                'email' => 'peter@architectstudio.com',
                'phone' => '+1-555-2004',
                'address' => '900 Design Plaza, Architecture City, AC 90000',
                'tax_id' => 'CUST005',
                'credit_limit' => 50000.00,
                'outstanding_balance' => 0.00,
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
