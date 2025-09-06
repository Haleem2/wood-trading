<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GoodsReceiptItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'goods_receipt_id',
        'item_id',
        'quantity_received',
        'quantity_defective',
        'quantity_wastage',
        'unit_cost',
        'landed_cost',
        'lot_no',
    ];

    protected $casts = [
        'quantity_received' => 'decimal:2',
        'quantity_defective' => 'decimal:2',
        'quantity_wastage' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'landed_cost' => 'decimal:2',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getNetQuantityAttribute()
    {
        return $this->quantity_received - $this->quantity_defective - $this->quantity_wastage;
    }

    public function getTotalCostAttribute()
    {
        return ($this->unit_cost * $this->net_quantity) + $this->landed_cost;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['goods_receipt_id', 'item_id', 'quantity_received', 'quantity_defective', 'quantity_wastage', 'unit_cost', 'landed_cost', 'lot_no'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
