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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Foreign key ke transactions
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key ke products
            $table->string('product_name'); // Nama produk saat transaksi (untuk history)
            $table->string('product_sku'); // SKU produk saat transaksi (untuk history)
            $table->decimal('unit_price', 15, 2); // Harga satuan saat transaksi
            $table->integer('quantity'); // Jumlah/kuantitas yang dibeli
            $table->decimal('discount_per_item', 15, 2)->default(0); // Diskon per item
            $table->decimal('subtotal', 15, 2); // Subtotal untuk item ini (qty * unit_price - discount)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
