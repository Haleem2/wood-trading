<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StockMovement extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'item_id',
        'warehouse_id',
        'stock_lot_id',
        'type',
        'movement',
        'quantity',
        'unit_cost',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function stockLot()
    {
        return $this->belongsTo(StockLot::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reference()
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['item_id', 'warehouse_id', 'stock_lot_id', 'type', 'movement', 'quantity', 'unit_cost', 'reference_type', 'reference_id', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
