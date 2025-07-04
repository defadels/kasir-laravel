<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $atk = Category::where('name', 'ATK (Alat Tulis Kantor)')->first();
        $printFotocopy = Category::where('name', 'Print & Fotocopy')->first();
        $sparepartKW = Category::where('name', 'Sparepart HP - Kualitas KW')->first();
        $sparepartOri = Category::where('name', 'Sparepart HP - Original Merk')->first();
        $sparepartAfter = Category::where('name', 'Sparepart HP - Original After Market')->first();

        $products = [
            // === ATK (Alat Tulis Kantor) ===
            [
                'name' => 'Pensil 2B',
                'sku' => 'ATK001',
                'description' => 'Pensil 2B kualitas standar untuk menulis dan menggambar',
                'category_id' => $atk->id,
                'price' => 2000,
                'cost_price' => 1200,
                'stock' => 500,
                'min_stock' => 50,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Bulpen Biru Standar',
                'sku' => 'ATK002',
                'description' => 'Pulpen tinta biru standar untuk keperluan sehari-hari',
                'category_id' => $atk->id,
                'price' => 3000,
                'cost_price' => 1800,
                'stock' => 300,
                'min_stock' => 30,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Map Plastik A4',
                'sku' => 'ATK003',
                'description' => 'Map plastik ukuran A4 untuk menyimpan dokumen',
                'category_id' => $atk->id,
                'price' => 5000,
                'cost_price' => 3000,
                'stock' => 200,
                'min_stock' => 20,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Amplop Putih Kecil',
                'sku' => 'ATK004',
                'description' => 'Amplop putih ukuran kecil untuk surat',
                'category_id' => $atk->id,
                'price' => 1500,
                'cost_price' => 800,
                'stock' => 1000,
                'min_stock' => 100,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Penggaris Plastik 30cm',
                'sku' => 'ATK005',
                'description' => 'Penggaris plastik transparant 30cm',
                'category_id' => $atk->id,
                'price' => 4000,
                'cost_price' => 2500,
                'stock' => 150,
                'min_stock' => 15,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Penghapus Putih',
                'sku' => 'ATK006',
                'description' => 'Penghapus putih standar untuk pensil',
                'category_id' => $atk->id,
                'price' => 2500,
                'cost_price' => 1500,
                'stock' => 200,
                'min_stock' => 25,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],

            // === Print & Fotocopy ===
            [
                'name' => 'Print Berwarna',
                'sku' => 'PRT001',
                'description' => 'Layanan print dokumen berwarna per lembar',
                'category_id' => $printFotocopy->id,
                'price' => 1000,
                'cost_price' => 600,
                'stock' => 0,
                'min_stock' => 0,
                'unit' => 'lembar',
                'is_active' => true,
                'track_stock' => false,
            ],
            [
                'name' => 'Print Hitam Putih',
                'sku' => 'PRT002',
                'description' => 'Layanan print dokumen hitam putih per lembar',
                'category_id' => $printFotocopy->id,
                'price' => 500,
                'cost_price' => 300,
                'stock' => 0,
                'min_stock' => 0,
                'unit' => 'lembar',
                'is_active' => true,
                'track_stock' => false,
            ],
            [
                'name' => 'Fotocopy Berwarna',
                'sku' => 'FCY001',
                'description' => 'Layanan fotocopy dokumen berwarna per lembar',
                'category_id' => $printFotocopy->id,
                'price' => 800,
                'cost_price' => 400,
                'stock' => 0,
                'min_stock' => 0,
                'unit' => 'lembar',
                'is_active' => true,
                'track_stock' => false,
            ],
            [
                'name' => 'Fotocopy Hitam Putih',
                'sku' => 'FCY002',
                'description' => 'Layanan fotocopy dokumen hitam putih per lembar',
                'category_id' => $printFotocopy->id,
                'price' => 200,
                'cost_price' => 100,
                'stock' => 0,
                'min_stock' => 0,
                'unit' => 'lembar',
                'is_active' => true,
                'track_stock' => false,
            ],

            // === Sparepart HP - Kualitas KW ===
            [
                'name' => 'LCD iPhone 12 KW',
                'sku' => 'KW001',
                'description' => 'LCD iPhone 12 kualitas KW (replika)',
                'category_id' => $sparepartKW->id,
                'price' => 250000,
                'cost_price' => 150000,
                'stock' => 20,
                'min_stock' => 3,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Baterai Samsung A52 KW',
                'sku' => 'KW002',
                'description' => 'Baterai Samsung Galaxy A52 kualitas KW',
                'category_id' => $sparepartKW->id,
                'price' => 80000,
                'cost_price' => 50000,
                'stock' => 15,
                'min_stock' => 2,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Kamera Belakang Xiaomi Redmi Note 10 KW',
                'sku' => 'KW003',
                'description' => 'Kamera belakang Xiaomi Redmi Note 10 kualitas KW',
                'category_id' => $sparepartKW->id,
                'price' => 120000,
                'cost_price' => 75000,
                'stock' => 10,
                'min_stock' => 2,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],

            // === Sparepart HP - Original Merk ===
            [
                'name' => 'LCD iPhone 12 Original',
                'sku' => 'ORI001',
                'description' => 'LCD iPhone 12 original dari pabrikan Apple',
                'category_id' => $sparepartOri->id,
                'price' => 1200000,
                'cost_price' => 900000,
                'stock' => 5,
                'min_stock' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Baterai Samsung A52 Original',
                'sku' => 'ORI002',
                'description' => 'Baterai Samsung Galaxy A52 original dari Samsung',
                'category_id' => $sparepartOri->id,
                'price' => 350000,
                'cost_price' => 250000,
                'stock' => 8,
                'min_stock' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Housing iPhone 13 Original',
                'sku' => 'ORI003',
                'description' => 'Housing/casing iPhone 13 original Apple',
                'category_id' => $sparepartOri->id,
                'price' => 800000,
                'cost_price' => 600000,
                'stock' => 3,
                'min_stock' => 1,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],

            // === Sparepart HP - Original After Market ===
            [
                'name' => 'LCD iPhone 12 After Market',
                'sku' => 'AFT001',
                'description' => 'LCD iPhone 12 original after market berkualitas tinggi',
                'category_id' => $sparepartAfter->id,
                'price' => 600000,
                'cost_price' => 400000,
                'stock' => 12,
                'min_stock' => 2,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Baterai Samsung A52 After Market',
                'sku' => 'AFT002',
                'description' => 'Baterai Samsung Galaxy A52 after market kualitas tinggi',
                'category_id' => $sparepartAfter->id,
                'price' => 180000,
                'cost_price' => 120000,
                'stock' => 18,
                'min_stock' => 3,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Kamera Belakang Xiaomi Redmi Note 10 After Market',
                'sku' => 'AFT003',
                'description' => 'Kamera belakang Xiaomi Redmi Note 10 after market',
                'category_id' => $sparepartAfter->id,
                'price' => 300000,
                'cost_price' => 200000,
                'stock' => 8,
                'min_stock' => 2,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
            [
                'name' => 'Housing Samsung A52 After Market',
                'sku' => 'AFT004',
                'description' => 'Housing/casing Samsung Galaxy A52 after market',
                'category_id' => $sparepartAfter->id,
                'price' => 200000,
                'cost_price' => 130000,
                'stock' => 15,
                'min_stock' => 2,
                'unit' => 'pcs',
                'is_active' => true,
                'track_stock' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Products for ATK & Print shop seeded successfully!');
    }
}
