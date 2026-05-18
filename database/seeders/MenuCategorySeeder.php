<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan',
                'image' => null,
                'description' => 'Berbagai pilihan makanan lezat dan mengenyangkan',
            ],
            [
                'name' => 'Minuman',
                'image' => null,
                'description' => 'Minuman segar dan menyegarkan',
            ],
            [
                'name' => 'Snack',
                'image' => null,
                'description' => 'Snack ringan dan gurih',
            ],
        ];

        foreach ($categories as $category) {
            MenuCategory::create($category);
        }
    }
}
