<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique(); // Kode transaksi unik (TR001, TR002, dll)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kasir yang melakukan transaksi
            $table->string('customer_name')->nullable(); // Nama customer (opsional)
            $table->string('customer_phone')->nullable(); // Phone customer (opsional)
            $table->decimal('subtotal', 15, 2); // Subtotal sebelum pajak/diskon
            $table->decimal('tax_amount', 15, 2)->default(0); // Jumlah pajak
            $table->decimal('discount_amount', 15, 2)->default(0); // Jumlah diskon
            $table->decimal('total_amount', 15, 2); // Total akhir yang dibayar
            $table->decimal('paid_amount', 15, 2); // Jumlah yang dibayar customer
            $table->decimal('change_amount', 15, 2)->default(0); // Kembalian
            $table->enum('payment_method', ['cash', 'card', 'qris', 'transfer'])->default('cash'); // Metode pembayaran
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed'); // Status transaksi
            $table->text('notes')->nullable(); // Catatan transaksi
            $table->timestamp('transaction_date'); // Waktu transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
