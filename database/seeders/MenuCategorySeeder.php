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
                'image' => 'categories/V35vwzZP049X2UXgCMLmmycWJAsgEYpanE1Qwc7d.png',
                'description' => 'Berbagai pilihan makanan lezat dan mengenyangkan',
            ],
            [
                'name' => 'Minuman',
                'image' => 'categories/Y0cC7m4VFWVmbuyriAEtmOprZ595DEGRCjjhSjNx.png',
                'description' => 'Minuman segar dan menyegarkan',
            ],
            [
                'name' => 'Snack',
                'image' => 'categories/yaU4hrVe3rV6P64P3AYIMPeP3aRNvjL0lOXojF9d.png',
                'description' => 'Snack ringan dan gurih',
            ],
        ];

        foreach ($categories as $category) {
            MenuCategory::create($category);
        }
    }
}
