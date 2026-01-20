<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Status constants biar konsisten
    public const STATUS_MENUNGGU_KONFIRMASI = 'MENUNGGU_KONFIRMASI';
    public const STATUS_DIPROSES = 'DIPROSES';
    public const STATUS_DIKIRIM = 'DIKIRIM';
    public const STATUS_SIAP_DIAMBIL = 'SIAP_DIAMBIL';
    public const STATUS_SELESAI = 'SELESAI';
    public const STATUS_DIBATALKAN = 'DIBATALKAN';

    // Fulfillment constants
    public const FULFILLMENT_DELIVERY = 'delivery';
    public const FULFILLMENT_PICKUP = 'pickup';

    protected $fillable = [
        'code',
        'customer_name',
        'phone',
        'fulfillment_type',
        'address',
        'note',
        'subtotal',
        'status',
        'tracking_token',
    ];

    protected $casts = [
        'subtotal' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalQtyAttribute(): int
    {
        return (int) $this->items()->sum('qty');
    }
}
