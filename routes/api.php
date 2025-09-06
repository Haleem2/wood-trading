<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\SalesOrderController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Inventory routes
    Route::apiResource('items', ItemController::class);
    Route::get('stock', [StockController::class, 'index']);
    Route::post('stock/adjust', [StockController::class, 'adjust']);
    
    // Customer routes
    Route::apiResource('customers', CustomerController::class);
    
    // Supplier routes
    Route::apiResource('suppliers', SupplierController::class);
    
    // Warehouse routes
    Route::apiResource('warehouses', WarehouseController::class);
    
    // Purchase Order routes
    Route::apiResource('purchase-orders', PurchaseOrderController::class);
    Route::post('purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive']);
    
    // Quotation routes
    Route::apiResource('quotations', QuotationController::class);
    Route::post('quotations/{quotation}/convert-to-sales-order', [QuotationController::class, 'convertToSalesOrder']);
    
    // Sales Order routes
    Route::apiResource('sales-orders', SalesOrderController::class);
    Route::post('sales-orders/{salesOrder}/deliver', [SalesOrderController::class, 'deliver']);
    
    // Invoice routes
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/generate-pdf', [InvoiceController::class, 'generatePdf']);
    
    // Payment routes
    Route::apiResource('payments', PaymentController::class);
    
    // Report routes
    Route::prefix('reports')->group(function () {
        Route::get('stock-valuation', [ReportController::class, 'stockValuation']);
        Route::get('sales-summary', [ReportController::class, 'salesSummary']);
        Route::get('purchase-summary', [ReportController::class, 'purchaseSummary']);
        Route::get('aging-receivables', [ReportController::class, 'agingReceivables']);
        Route::get('aging-payables', [ReportController::class, 'agingPayables']);
        Route::get('low-stock-alerts', [ReportController::class, 'lowStockAlerts']);
    });
});
