<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Item extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'species',
        'grade',
        'thickness',
        'width',
        'length',
        'unit',
        'barcode',
        'moisture_level',
        'low_stock_threshold',
        'costing_method',
        'is_active',
    ];

    protected $casts = [
        'thickness' => 'decimal:2',
        'width' => 'decimal:2',
        'length' => 'decimal:2',
        'moisture_level' => 'decimal:2',
        'low_stock_threshold' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function stockLots()
    {
        return $this->hasMany(StockLot::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function deliveryNoteItems()
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getTotalStockAttribute()
    {
        return $this->stockLots()->sum('qty_on_hand');
    }

    public function getAvailableStockAttribute()
    {
        return $this->stockLots()->sum('qty_available');
    }

    public function getReservedStockAttribute()
    {
        return $this->stockLots()->sum('qty_reserved');
    }

    public function isLowStock()
    {
        return $this->available_stock <= $this->low_stock_threshold;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'name', 'species', 'grade', 'thickness', 'width', 'length', 'unit', 'barcode', 'moisture_level', 'low_stock_threshold', 'costing_method', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
