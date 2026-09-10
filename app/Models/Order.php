<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'customer_phone',
        'status', 'notes', 'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getAddOnTotalAttribute(): int
    {
        return $this->items
            ->where('item_type', 'addon')
            ->sum(fn (OrderItem $item) => $item->unit_price * $item->quantity);
    }

    public function getTotalAttribute(): int
    {
        return $this->items->sum(fn (OrderItem $item) => $item->unit_price * $item->quantity);
    }
}
