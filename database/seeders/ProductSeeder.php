<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Contoh di dalam ProductSeeder.php
public function run(): void
{
    \App\Models\Product::create([
        'user_id' => 1, // Pastikan user dengan ID 1 sudah ada
        'name' => 'Kalkulus Purcell Edisi 9',
        'category' => 'Buku Kuliah',
        'price' => 85000,
        'description' => 'Kondisi mulus, tidak ada coretan.',
        'location' => 'Sekitar Kampus IKMI',
        'whatsapp_number' => '628123456789',
        'image' => 'products/buku.jpg' // Tambahkan prefix folder products/
    ]);
}
}
