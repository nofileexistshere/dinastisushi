<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
        ]);

        $user3 = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create menu items
        $menuItems = [
            // Nigiri
            [
                'name' => 'Salmon Nigiri',
                'description' => 'Nasi sushi dengan irisan salmon segar premium',
                'price' => 25000,
                'category' => 'Nigiri',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Salmon', 'Nasi Sushi', 'Nori'],
            ],
            [
                'name' => 'Tuna Nigiri',
                'description' => 'Nasi sushi dengan irisan tuna segar',
                'price' => 28000,
                'category' => 'Nigiri',
                'image' => 'https://images.unsplash.com/photo-1564489563601-c53cfc451e93?w=400',
                'tags' => ['Tuna', 'Nasi Sushi'],
            ],
            [
                'name' => 'Ebi Nigiri',
                'description' => 'Nasi sushi dengan udang premium',
                'price' => 22000,
                'category' => 'Nigiri',
                'image' => 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=400',
                'tags' => ['Udang', 'Nasi Sushi'],
            ],
            // Maki
            [
                'name' => 'Tuna Roll',
                'description' => 'Gulungan sushi dengan tuna segar dan sayuran',
                'price' => 30000,
                'category' => 'Maki',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Tuna', 'Nasi Sushi', 'Nori'],
            ],
            [
                'name' => 'California Roll',
                'description' => 'Roll klasik dengan kepiting, alpukat, dan mentimun',
                'price' => 28000,
                'category' => 'Maki',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Kepiting', 'Alpukat', 'Mentimun'],
            ],
            [
                'name' => 'Spicy Salmon Roll',
                'description' => 'Roll pedas dengan salmon dan mayo pedas',
                'price' => 33000,
                'category' => 'Maki',
                'image' => 'https://images.unsplash.com/photo-1563612116625-3012372fccce?w=400',
                'tags' => ['Salmon', 'Pedas', 'Mayo'],
            ],
            // Sashimi
            [
                'name' => 'Salmon Sashimi',
                'description' => 'Irisan salmon segar tanpa nasi',
                'price' => 45000,
                'category' => 'Sashimi',
                'image' => 'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=400',
                'tags' => ['Salmon', 'Premium'],
            ],
            [
                'name' => 'Tuna Sashimi',
                'description' => 'Irisan tuna segar premium',
                'price' => 48000,
                'category' => 'Sashimi',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Tuna', 'Premium'],
            ],
            // Special
            [
                'name' => 'Rainbow Roll',
                'description' => 'Roll premium dengan berbagai jenis ikan',
                'price' => 52000,
                'category' => 'Special',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Premium', 'Mix'],
            ],
            [
                'name' => 'Dragon Roll',
                'description' => 'Roll spesial dengan belut dan alpukat',
                'price' => 55000,
                'category' => 'Special',
                'image' => 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=400',
                'tags' => ['Belut', 'Alpukat', 'Premium'],
            ],
        ];

        $createdMenuItems = [];
        foreach ($menuItems as $item) {
            $createdMenuItems[] = MenuItem::create($item);
        }

        // Create some orders and ratings for Budi Santoso
        $orders = [
            ['menu_item_id' => $createdMenuItems[0]->id, 'quantity' => 2, 'rating' => 4],
            ['menu_item_id' => $createdMenuItems[3]->id, 'quantity' => 1, 'rating' => 5],
            ['menu_item_id' => $createdMenuItems[5]->id, 'quantity' => 1, 'rating' => 4],
            ['menu_item_id' => $createdMenuItems[7]->id, 'quantity' => 1, 'rating' => 5],
            ['menu_item_id' => $createdMenuItems[8]->id, 'quantity' => 2, 'rating' => 4],
        ];

        foreach ($orders as $orderData) {
            $menuItem = MenuItem::find($orderData['menu_item_id']);
            
            $order = Order::create([
                'user_id' => $user1->id,
                'menu_item_id' => $orderData['menu_item_id'],
                'quantity' => $orderData['quantity'],
                'total_price' => $menuItem->price * $orderData['quantity'],
            ]);

            Rating::create([
                'user_id' => $user1->id,
                'menu_item_id' => $orderData['menu_item_id'],
                'rating' => $orderData['rating'],
            ]);
        }

        // Create some orders for other users to enable collaborative filtering
        Order::create([
            'user_id' => $user2->id,
            'menu_item_id' => $createdMenuItems[0]->id,
            'quantity' => 1,
            'total_price' => $createdMenuItems[0]->price,
        ]);
        Rating::create([
            'user_id' => $user2->id,
            'menu_item_id' => $createdMenuItems[0]->id,
            'rating' => 5,
        ]);

        Order::create([
            'user_id' => $user2->id,
            'menu_item_id' => $createdMenuItems[3]->id,
            'quantity' => 1,
            'total_price' => $createdMenuItems[3]->price,
        ]);
        Rating::create([
            'user_id' => $user2->id,
            'menu_item_id' => $createdMenuItems[3]->id,
            'rating' => 4,
        ]);

        // Update average ratings for all menu items
        foreach ($createdMenuItems as $menuItem) {
            $ratings = Rating::where('menu_item_id', $menuItem->id)->get();
            if ($ratings->count() > 0) {
                $menuItem->average_rating = $ratings->avg('rating');
                $menuItem->rating_count = $ratings->count();
                $menuItem->save();
            }
        }
    }
}
