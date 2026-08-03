<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $menuItems = MenuItem::all();

        if ($menuItems->isEmpty()) {
            $this->command->warn('No menu items found. Please run MenuItemSeeder first.');
            return;
        }

        // Create some sample orders
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'table_number' => rand(1, 10),
                'order_code' => 'ORD-' . now()->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'customer_name' => 'Customer ' . $i,
                'total_price' => 0,
                'order_status' => ['pending', 'diproses', 'done'][rand(0, 2)],
                'payment_status' => 'paid',
            ]);

            // Add random items to each order
            $totalPrice = 0;
            $numItems = rand(1, 3);

            for ($j = 0; $j < $numItems; $j++) {
                $menuItem = $menuItems->random();
                $qty = rand(1, 3);
                $subtotal = $menuItem->price * $qty;
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'qty' => $qty,
                    'price' => $menuItem->price,
                    'notes' => rand(0, 1) ? 'Extra spicy' : null,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
        }
    }
}
