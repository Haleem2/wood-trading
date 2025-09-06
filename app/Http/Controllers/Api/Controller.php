<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title="Wood Trading API",
     *     version="1.0.0",
     *     description="API for Wood Trading Application - A comprehensive system for managing wood inventory, sales, purchases, and financial operations.",
     *     @OA\Contact(
     *         email="support@woodtrading.com",
     *         name="Wood Trading Support"
     *     ),
     *     @OA\License(
     *         name="MIT",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     * 
     * @OA\Server(
     *     url="http://localhost:8000/api",
     *     description="Local Development Server"
     * )
     * 
     * @OA\Server(
     *     url="https://api.woodtrading.com/api",
     *     description="Production Server"
     * )
     * 
     * @OA\Tag(
     *     name="Authentication",
     *     description="User authentication and authorization"
     * )
     * 
     * @OA\Tag(
     *     name="Inventory",
     *     description="Item and stock management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Customers",
     *     description="Customer management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Suppliers",
     *     description="Supplier management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Purchase Orders",
     *     description="Purchase order management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Quotations",
     *     description="Quotation management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Sales Orders",
     *     description="Sales order management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Invoices",
     *     description="Invoice management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Payments",
     *     description="Payment management operations"
     * )
     * 
     * @OA\Tag(
     *     name="Reports",
     *     description="Reporting and analytics operations"
     * )
     */
    public function __construct()
    {
        //
    }
}
