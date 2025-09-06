<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'invoice_number',
        'sales_order_id',
        'customer_id',
        'issued_at',
        'due_date',
        'currency',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'tax_total',
        'total',
        'amount_paid',
        'balance_due',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($invoice) {
            $invoice->balance_due = $invoice->total - $invoice->amount_paid;
        });
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
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
            'balance_due' => ($subtotal - $discountAmount + $this->tax_total) - $this->amount_paid,
        ]);
    }

    public function isOverdue()
    {
        return $this->due_date->isPast() && $this->balance_due > 0;
    }

    public function isPaid()
    {
        return $this->balance_due <= 0;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['invoice_number', 'sales_order_id', 'customer_id', 'issued_at', 'due_date', 'currency', 'subtotal', 'discount_percent', 'discount_amount', 'tax_total', 'total', 'amount_paid', 'balance_due', 'status', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
