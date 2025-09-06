<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PurchaseOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'po_number',
        'supplier_id',
        'status',
        'expected_at',
        'currency',
        'subtotal',
        'tax_total',
        'total',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'expected_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function calculateTotals()
    {
        $subtotal = $this->items()->sum('line_total');
        $this->update([
            'subtotal' => $subtotal,
            'total' => $subtotal + $this->tax_total,
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['po_number', 'supplier_id', 'status', 'expected_at', 'currency', 'subtotal', 'tax_total', 'total', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
