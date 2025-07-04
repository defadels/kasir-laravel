<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'ATK (Alat Tulis Kantor)',
                'description' => 'Pensil, bulpen, map, amplop, penggaris, penghapus, dan perlengkapan tulis lainnya',
                'is_active' => true,
            ],
            [
                'name' => 'Print & Fotocopy',
                'description' => 'Layanan print dan fotocopy dengan variasi harga berwarna dan hitam putih',
                'is_active' => true,
            ],
            [
                'name' => 'Sparepart HP - Kualitas KW',
                'description' => 'Suku cadang handphone kualitas KW (replika) dengan harga terjangkau',
                'is_active' => true,
            ],
            [
                'name' => 'Sparepart HP - Original Merk',
                'description' => 'Suku cadang handphone original dari pabrikan dengan kualitas terbaik',
                'is_active' => true,
            ],
            [
                'name' => 'Sparepart HP - Original After Market',
                'description' => 'Suku cadang handphone original after market dengan kualitas standar tinggi',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'is_active' => $categoryData['is_active'],
            ]);
        }

        $this->command->info('Categories for ATK & Print shop seeded successfully!');
    }
}
