<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GoodsReceipt extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'purchase_order_id',
        'reference_no',
        'received_at',
        'warehouse_id',
        'transport_cost',
        'customs_cost',
        'handling_cost',
        'notes',
        'received_by',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'transport_cost' => 'decimal:2',
        'customs_cost' => 'decimal:2',
        'handling_cost' => 'decimal:2',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function getTotalLandedCostAttribute()
    {
        return $this->transport_cost + $this->customs_cost + $this->handling_cost;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['purchase_order_id', 'reference_no', 'received_at', 'warehouse_id', 'transport_cost', 'customs_cost', 'handling_cost', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
