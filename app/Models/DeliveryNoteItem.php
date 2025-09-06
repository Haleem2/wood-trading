<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DeliveryNoteItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'delivery_note_id',
        'item_id',
        'quantity_delivered',
    ];

    protected $casts = [
        'quantity_delivered' => 'decimal:2',
    ];

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['delivery_note_id', 'item_id', 'quantity_delivered'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
