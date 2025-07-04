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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama produk
            $table->string('sku')->unique(); // Stock Keeping Unit (barcode/kode produk)
            $table->text('description')->nullable(); // Deskripsi produk
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key ke categories
            $table->decimal('price', 15, 2); // Harga produk
            $table->decimal('cost_price', 15, 2)->nullable(); // Harga beli/modal
            $table->integer('stock')->default(0); // Stok saat ini
            $table->integer('min_stock')->default(0); // Minimum stok untuk alert
            $table->string('unit')->default('pcs'); // Satuan (pcs, kg, liter, dll)
            $table->string('image')->nullable(); // Gambar produk
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->boolean('track_stock')->default(true); // Apakah stok ditracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
