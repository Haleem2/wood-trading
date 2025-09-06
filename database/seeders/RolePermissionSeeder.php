<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Inventory permissions
            'view_items', 'create_items', 'edit_items', 'delete_items',
            'view_stock', 'adjust_stock', 'view_stock_movements',
            
            // Purchase permissions
            'view_purchase_orders', 'create_purchase_orders', 'edit_purchase_orders', 'delete_purchase_orders',
            'receive_goods', 'view_suppliers', 'create_suppliers', 'edit_suppliers', 'delete_suppliers',
            
            // Sales permissions
            'view_quotations', 'create_quotations', 'edit_quotations', 'delete_quotations',
            'view_sales_orders', 'create_sales_orders', 'edit_sales_orders', 'delete_sales_orders',
            'view_invoices', 'create_invoices', 'edit_invoices', 'delete_invoices',
            'view_delivery_notes', 'create_delivery_notes', 'edit_delivery_notes',
            'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
            
            // Finance permissions
            'view_payments', 'create_payments', 'edit_payments', 'delete_payments',
            'view_financial_reports', 'view_aging_reports',
            
            // System permissions
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
            'view_warehouses', 'create_warehouses', 'edit_warehouses', 'delete_warehouses',
            'view_activity_logs', 'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $ownerRole = Role::create(['name' => 'Owner/Admin', 'guard_name' => 'web']);
        $ownerRole->givePermissionTo(Permission::all());

        $salesRole = Role::create(['name' => 'Salesperson', 'guard_name' => 'web']);
        $salesRole->givePermissionTo([
            'view_items', 'view_stock', 'view_stock_movements',
            'view_quotations', 'create_quotations', 'edit_quotations',
            'view_sales_orders', 'create_sales_orders', 'edit_sales_orders',
            'view_invoices', 'create_invoices', 'edit_invoices',
            'view_delivery_notes', 'create_delivery_notes', 'edit_delivery_notes',
            'view_customers', 'create_customers', 'edit_customers',
            'view_payments', 'create_payments',
            'view_reports',
        ]);

        $storekeeperRole = Role::create(['name' => 'Storekeeper', 'guard_name' => 'web']);
        $storekeeperRole->givePermissionTo([
            'view_items', 'view_stock', 'adjust_stock', 'view_stock_movements',
            'view_purchase_orders', 'receive_goods',
            'view_delivery_notes', 'create_delivery_notes', 'edit_delivery_notes',
            'view_warehouses',
        ]);

        $accountantRole = Role::create(['name' => 'Accountant', 'guard_name' => 'web']);
        $accountantRole->givePermissionTo([
            'view_items', 'view_stock', 'view_stock_movements',
            'view_purchase_orders', 'view_suppliers',
            'view_quotations', 'view_sales_orders', 'view_invoices',
            'view_delivery_notes', 'view_customers',
            'view_payments', 'create_payments', 'edit_payments',
            'view_financial_reports', 'view_aging_reports', 'view_reports',
        ]);
    }
}
