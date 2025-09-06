<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InvoiceItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity',
        'unit_price',
        'discount_percent',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'line_total',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->discount_amount = ($item->quantity * $item->unit_price) * ($item->discount_percent / 100);
            $subtotal = ($item->quantity * $item->unit_price) - $item->discount_amount;
            $item->tax_amount = $subtotal * ($item->tax_percent / 100);
            $item->line_total = $subtotal + $item->tax_amount;
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['invoice_id', 'item_id', 'quantity', 'unit_price', 'discount_percent', 'discount_amount', 'tax_percent', 'tax_amount', 'line_total'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
