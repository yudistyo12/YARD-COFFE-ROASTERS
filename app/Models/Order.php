<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'pending' => 'Menunggu konfirmasi',
        'confirmed' => 'Dikonfirmasi',
        'preparing' => 'Sedang disiapkan',
        'ready' => 'Siap diambil / diantar',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'email', 'fulfillment_method',
        'delivery_address', 'notes', 'total_price', 'status',
    ];

    protected function casts(): array
    {
        return ['total_price' => 'decimal:2'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }
}
