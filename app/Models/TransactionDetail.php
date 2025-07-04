<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'product_sku',
        'unit_price',
        'quantity',
        'discount_per_item',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
        'discount_per_item' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationship dengan Transaction
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relationship dengan Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Auto calculate subtotal when creating/updating
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->subtotal = ($detail->unit_price * $detail->quantity) - $detail->discount_per_item;
        });
    }

    // Method untuk format subtotal
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Method untuk format unit price
    public function getFormattedUnitPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->unit_price, 0, ',', '.');
    }

    // Method untuk total discount
    public function getTotalDiscountAttribute(): float
    {
        return $this->discount_per_item * $this->quantity;
    }
}
