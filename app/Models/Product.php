<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'price',
        'cost_price',
        'stock',
        'min_stock',
        'unit',
        'image',
        'is_active',
        'track_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
        'track_stock' => 'boolean',
    ];

    // Relationship dengan Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship dengan TransactionDetail
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk produk dengan stok rendah
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock')
                    ->where('track_stock', true);
    }

    // Method untuk cek apakah stok rendah
    public function isLowStock(): bool
    {
        return $this->track_stock && $this->stock <= $this->min_stock;
    }

    // Method untuk mengurangi stok
    public function reduceStock(int $quantity): bool
    {
        if (!$this->track_stock) {
            return true;
        }

        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            return $this->save();
        }

        return false;
    }

    // Method untuk menambah stok
    public function addStock(int $quantity): bool
    {
        if (!$this->track_stock) {
            return true;
        }

        $this->stock += $quantity;
        return $this->save();
    }

    // Method untuk format harga
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
