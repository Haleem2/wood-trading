<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SalesOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'so_number',
        'customer_id',
        'quotation_id',
        'status',
        'required_at',
        'currency',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'tax_total',
        'total',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'required_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function deliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function calculateTotals()
    {
        $subtotal = $this->items()->sum('line_total');
        $discountAmount = $subtotal * ($this->discount_percent / 100);
        $this->update([
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total' => $subtotal - $discountAmount + $this->tax_total,
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['so_number', 'customer_id', 'quotation_id', 'status', 'required_at', 'currency', 'subtotal', 'discount_percent', 'discount_amount', 'tax_total', 'total', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
