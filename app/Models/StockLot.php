<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StockLot extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'item_id',
        'warehouse_id',
        'lot_no',
        'qty_on_hand',
        'qty_reserved',
        'qty_available',
        'cost',
        'received_at',
        'expires_at',
    ];

    protected $casts = [
        'qty_on_hand' => 'decimal:2',
        'qty_reserved' => 'decimal:2',
        'qty_available' => 'decimal:2',
        'cost' => 'decimal:2',
        'received_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($stockLot) {
            $stockLot->qty_available = $stockLot->qty_on_hand - $stockLot->qty_reserved;
        });
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['item_id', 'warehouse_id', 'lot_no', 'qty_on_hand', 'qty_reserved', 'cost', 'received_at', 'expires_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
