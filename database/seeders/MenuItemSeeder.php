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

        // Get available images from storage
        $images = [
            'menu-images/1hl2l7WcPob1gwdglMjosAwa0FiVXar4T3PjEhnJ.jpg',
            'menu-images/41YMmjjV6KNGZmg6kdkhdfnJeug7IksMsPkXMb36.webp',
            'menu-images/BuyEgGLyrUPQpkYX4T57UOcIcZItFtqBBBGTvsm4.jpg',
            'menu-images/E5nbkolVVicHH45IROEVBAmep1TngfSbWJBKimRh.jpg',
            'menu-images/I8R4CGB0CwYLrFzfk8rA6wqYkMDe3VkJP4S0HC1L.jpg',
            'menu-images/QwY69ryZvzGKUxGIULSYQEPvMAgFVbAYJ2ji359c.jpg',
            'menu-images/RhBbQ4Km4M4FIMd1dJevhXaW2XzBtcaSagDS7k9i.jpg',
            'menu-images/TpC2ywHqin7uj2pAM4JlcMAGtU4bBbhbYYT18R8m.jpg',
            'menu-images/UbMgey22OtBtEHdWM8t3ewKJIx8ZFpLhMHN7I4tk.jpg',
        ];

        $menuItems = [
            [
                'category_id' => $makananCategory->id,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
                'price' => 25000,
                'image' => $images[0],
                'is_available' => true,
            ],
            [
                'category_id' => $makananCategory->id,
                'name' => 'Mie Ayam Bakso',
                'description' => 'Mie ayam dengan bakso sapi dan kuah kaldu',
                'price' => 20000,
                'image' => $images[1],
                'is_available' => true,
            ],
            [
                'category_id' => $makananCategory->id,
                'name' => 'Ayam Goreng Crispy',
                'description' => 'Ayam goreng renyah dengan sambal',
                'price' => 22000,
                'image' => $images[2],
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin segar',
                'price' => 5000,
                'image' => $images[3],
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Es Jeruk',
                'description' => 'Jus jeruk segar dengan es',
                'price' => 8000,
                'image' => $images[4],
                'is_available' => true,
            ],
            [
                'category_id' => $minumanCategory->id,
                'name' => 'Kopi Susu',
                'description' => 'Kopi susu gula aren',
                'price' => 15000,
                'image' => $images[5],
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng dengan saus',
                'price' => 12000,
                'image' => $images[6],
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng crispy dengan topping',
                'price' => 10000,
                'image' => $images[7],
                'is_available' => true,
            ],
            [
                'category_id' => $snackCategory->id,
                'name' => 'Roti Bakar',
                'description' => 'Roti bakar dengan selai dan coklat',
                'price' => 15000,
                'image' => $images[8],
                'is_available' => true,
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}
