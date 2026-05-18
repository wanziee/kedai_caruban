<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\MenuCategory;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makananCategory = MenuCategory::where('name', 'Makanan')->first();
        $minumanCategory = MenuCategory::where('name', 'Minuman')->first();
        $snackCategory = MenuCategory::where('name', 'Snack')->first();

        $menuItems = [
            [
                'category_id' => $makananCategory->id,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
                'price' => 25000,
                'is_available' => true,
            ],
            [
                'category_id' => $makananCategory->id,
                'name' => 'Mie Ayam Bakso',
                'description' => 'Mie ayam dengan bakso sapi dan kuah kaldu',
                'price' => 20000,
                'is_available' => true,
            ],
            [
                'category_id' => $makananCategory->id,
                'name' => 'Ayam Goreng Crispy',
                'description' => 'Ayam goreng renyah dengan sambal',
                'price' => 22000,
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin segar',
                'price' => 5000,
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Es Jeruk',
                'description' => 'Jus jeruk segar dengan es',
                'price' => 8000,
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Kopi Susu',
                'description' => 'Kopi susu gula aren',
                'price' => 15000,
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng dengan saus',
                'price' => 12000,
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng crispy dengan topping',
                'price' => 10000,
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Roti Bakar',
                'description' => 'Roti bakar dengan selai dan coklat',
                'price' => 15000,
                'is_available' => true,
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}
