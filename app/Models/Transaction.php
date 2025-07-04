<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'user_id',
        'customer_name',
        'customer_phone',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'change_amount',
        'payment_method',
        'status',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    // Relationship dengan User (Kasir)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan TransactionDetail
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Auto generate transaction code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = static::generateTransactionCode();
            }
            if (empty($transaction->transaction_date)) {
                $transaction->transaction_date = now();
            }
        });
    }

    // Generate unique transaction code
    private static function generateTransactionCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        $count = static::whereDate('created_at', Carbon::today())->count() + 1;
        return 'TR' . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Scope untuk transaksi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('transaction_date', Carbon::today());
    }

    // Scope untuk transaksi bulan ini
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('transaction_date', Carbon::now()->month)
                    ->whereYear('transaction_date', Carbon::now()->year);
    }

    // Scope untuk transaksi berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Method untuk format total
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // Method untuk format payment method
    public function getFormattedPaymentMethodAttribute(): string
    {
        return match($this->payment_method) {
            'cash' => 'Tunai',
            'card' => 'Kartu',
            'qris' => 'QRIS',
            'transfer' => 'Transfer',
            default => $this->payment_method
        };
    }
}
