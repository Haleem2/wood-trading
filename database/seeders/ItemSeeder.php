<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            // Pine Wood Items
            [
                'code' => 'PINE-2X4-8',
                'name' => 'Pine 2x4 8ft',
                'species' => 'Pine',
                'grade' => 'A',
                'thickness' => 38.1, // 1.5 inches in mm
                'width' => 88.9, // 3.5 inches in mm
                'length' => 2438.4, // 8 feet in mm
                'unit' => 'piece',
                'barcode' => '1234567890123',
                'moisture_level' => 12.0,
                'low_stock_threshold' => 50.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            [
                'code' => 'PINE-2X6-8',
                'name' => 'Pine 2x6 8ft',
                'species' => 'Pine',
                'grade' => 'A',
                'thickness' => 38.1,
                'width' => 139.7, // 5.5 inches in mm
                'length' => 2438.4,
                'unit' => 'piece',
                'barcode' => '1234567890124',
                'moisture_level' => 12.0,
                'low_stock_threshold' => 30.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            [
                'code' => 'PINE-1X4-8',
                'name' => 'Pine 1x4 8ft',
                'species' => 'Pine',
                'grade' => 'B',
                'thickness' => 19.05, // 0.75 inches in mm
                'width' => 88.9,
                'length' => 2438.4,
                'unit' => 'piece',
                'barcode' => '1234567890125',
                'moisture_level' => 15.0,
                'low_stock_threshold' => 100.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            
            // Oak Wood Items
            [
                'code' => 'OAK-2X4-8',
                'name' => 'Oak 2x4 8ft',
                'species' => 'Oak',
                'grade' => 'Premium',
                'thickness' => 38.1,
                'width' => 88.9,
                'length' => 2438.4,
                'unit' => 'piece',
                'barcode' => '1234567890126',
                'moisture_level' => 8.0,
                'low_stock_threshold' => 20.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            [
                'code' => 'OAK-1X6-8',
                'name' => 'Oak 1x6 8ft',
                'species' => 'Oak',
                'grade' => 'Premium',
                'thickness' => 19.05,
                'width' => 139.7,
                'length' => 2438.4,
                'unit' => 'piece',
                'barcode' => '1234567890127',
                'moisture_level' => 8.0,
                'low_stock_threshold' => 15.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            
            // Beech Wood Items
            [
                'code' => 'BEECH-2X8-10',
                'name' => 'Beech 2x8 10ft',
                'species' => 'Beech',
                'grade' => 'A',
                'thickness' => 38.1,
                'width' => 184.15, // 7.25 inches in mm
                'length' => 3048.0, // 10 feet in mm
                'unit' => 'piece',
                'barcode' => '1234567890128',
                'moisture_level' => 10.0,
                'low_stock_threshold' => 25.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            
            // Plywood Items
            [
                'code' => 'PLY-3/4-4X8',
                'name' => 'Plywood 3/4" 4x8',
                'species' => 'Mixed',
                'grade' => 'CDX',
                'thickness' => 19.05, // 3/4 inch in mm
                'width' => 1219.2, // 4 feet in mm
                'length' => 2438.4, // 8 feet in mm
                'unit' => 'sheet',
                'barcode' => '1234567890129',
                'moisture_level' => 12.0,
                'low_stock_threshold' => 40.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            [
                'code' => 'PLY-1/2-4X8',
                'name' => 'Plywood 1/2" 4x8',
                'species' => 'Mixed',
                'grade' => 'CDX',
                'thickness' => 12.7, // 1/2 inch in mm
                'width' => 1219.2,
                'length' => 2438.4,
                'unit' => 'sheet',
                'barcode' => '1234567890130',
                'moisture_level' => 12.0,
                'low_stock_threshold' => 60.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
            
            // MDF Items
            [
                'code' => 'MDF-3/4-4X8',
                'name' => 'MDF 3/4" 4x8',
                'species' => 'Engineered',
                'grade' => 'Standard',
                'thickness' => 19.05,
                'width' => 1219.2,
                'length' => 2438.4,
                'unit' => 'sheet',
                'barcode' => '1234567890131',
                'moisture_level' => 8.0,
                'low_stock_threshold' => 30.0,
                'costing_method' => 'FIFO',
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
