<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DeliveryNote extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'dn_number',
        'sales_order_id',
        'delivered_at',
        'vehicle',
        'driver',
        'delivery_address',
        'notes',
        'delivered_by',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function items()
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }

    public function deliveredBy()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['dn_number', 'sales_order_id', 'delivered_at', 'vehicle', 'driver', 'delivery_address', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
