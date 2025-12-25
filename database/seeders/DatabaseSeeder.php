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
        // Create admin user
        $admin = User::create([
            'name' => 'Admin Dinasti Sushi',
            'email' => 'admin@dinastisushi.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create demo users
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $user3 = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create menu items
        $menuItems = [
            // 1. Sushi Roll (Maki, Roll, Inari, Gunkan)
            [
                'name' => 'Salmon Maki',
                'description' => 'Gulungan nasi sushi kecil dengan isian salmon segar',
                'price' => 25000,
                'category' => 'Sushi Roll',
                'image' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400',
                'tags' => ['Salmon', 'Maki', 'Nori'],
            ],
            [
                'name' => 'California Roll',
                'description' => 'Roll klasik dengan kepiting, alpukat, dan mentimun',
                'price' => 30000,
                'category' => 'Sushi Roll',
                'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400',
                'tags' => ['Kepiting', 'Alpukat', 'Roll'],
            ],
            [
                'name' => 'Inari Sushi',
                'description' => 'Kantong tahu manis berisi nasi sushi',
                'price' => 18000,
                'category' => 'Sushi Roll',
                'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400', // Placeholder
                'tags' => ['Tahu', 'Manis', 'Inari'],
            ],
            [
                'name' => 'Tobiko Gunkan',
                'description' => 'Nasi sushi dibalut nori dengan topping telur ikan terbang',
                'price' => 35000,
                'category' => 'Sushi Roll',
                'image' => 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=400',
                'tags' => ['Tobiko', 'Gunkan', 'Telur Ikan'],
            ],

            // 2. Nigiri & Sashimi (termasuk stray)
            [
                'name' => 'Salmon Nigiri',
                'description' => 'Nasi sushi dengan irisan salmon segar premium',
                'price' => 25000,
                'category' => 'Nigiri & Sashimi',
                'image' => 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=400',
                'tags' => ['Salmon', 'Nasi Sushi', 'Nigiri'],
            ],
            [
                'name' => 'Tuna Sashimi',
                'description' => 'Irisan tuna segar premium tanpa nasi',
                'price' => 45000,
                'category' => 'Nigiri & Sashimi',
                'image' => 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=400',
                'tags' => ['Tuna', 'Premium', 'Sashimi'],
            ],
            [
                'name' => 'Ebi Nigiri',
                'description' => 'Nasi sushi dengan udang rebus',
                'price' => 22000,
                'category' => 'Nigiri & Sashimi',
                'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400',
                'tags' => ['Udang', 'Nigiri'],
            ],

            // 3. Ramen dan Udon
            [
                'name' => 'Miso Ramen',
                'description' => 'Mie ramen dengan kuah miso yang gurih, chashu ayam, dan telur',
                'price' => 45000,
                'category' => 'Ramen & Udon',
                'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400',
                'tags' => ['Ramen', 'Miso', 'Kuah'],
            ],
            [
                'name' => 'Tempura Udon',
                'description' => 'Mie udon tebal dengan kuah dashi dan topping tempura udang',
                'price' => 48000,
                'category' => 'Ramen & Udon',
                'image' => 'https://images.unsplash.com/photo-1548865166-52bd6d389596?w=400',
                'tags' => ['Udon', 'Tempura', 'Kuah'],
            ],
            [
                'name' => 'Spicy Ramen',
                'description' => 'Ramen kuah pedas level 3 dengan daging cincang',
                'price' => 47000,
                'category' => 'Ramen & Udon',
                'image' => 'https://images.unsplash.com/photo-1591814468924-caf88d1232e1?w=400',
                'tags' => ['Ramen', 'Pedas'],
            ],

            // 4. Snack & Dessert (termasuk cemilan)
            [
                'name' => 'Edamame',
                'description' => 'Kacang kedelai muda rebus dengan garam laut',
                'price' => 15000,
                'category' => 'Snack & Dessert',
                'image' => 'https://images.unsplash.com/photo-1627042633145-b780d842b65e?w=400',
                'tags' => ['Sehat', 'Cemilan'],
            ],
            [
                'name' => 'Takoyaki',
                'description' => 'Bola-bola tepung isi gurita (6 pcs)',
                'price' => 25000,
                'category' => 'Snack & Dessert',
                'image' => 'https://images.unsplash.com/photo-1615887023516-9b6e51f4c787?w=400',
                'tags' => ['Gurita', 'Panas', 'Snack'],
            ],
            [
                'name' => 'Matcha Ice Cream',
                'description' => 'Es krim rasa teh hijau Jepang otentik',
                'price' => 20000,
                'category' => 'Snack & Dessert',
                'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400',
                'tags' => ['Manis', 'Dingin', 'Dessert'],
            ],
             [
                'name' => 'Mochi Ice Cream',
                'description' => 'Kue mochi kenyal dengan isi es krim (2 pcs)',
                'price' => 22000,
                'category' => 'Snack & Dessert',
                'image' => 'https://images.unsplash.com/photo-1623592945627-2c5e538d3394?w=400',
                'tags' => ['Mochi', 'Manis', 'Dessert'],
            ],

            // 5. Rice (bowl & nasi mentai)
            [
                'name' => 'Chicken Katsu Don',
                'description' => 'Nasi bowl dengan ayam katsu dan telur',
                'price' => 35000,
                'category' => 'Rice',
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400',
                'tags' => ['Ayam', 'Nasi', 'Bowl'],
            ],
            [
                'name' => 'Salmon Mentai Rice',
                'description' => 'Nasi dengan topping salmon dan saus mentai bakar',
                'price' => 45000,
                'category' => 'Rice',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400',
                'tags' => ['Salmon', 'Mentai', 'Nasi'],
            ],
            [
                'name' => 'Beef Teriyaki Bowl',
                'description' => 'Nasi bowl dengan irisan daging sapi saus teriyaki',
                'price' => 42000,
                'category' => 'Rice',
                'image' => 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=400',
                'tags' => ['Sapi', 'Teriyaki', 'Bowl'],
            ],

            // 6. Party (termasuk sushi box)
            [
                'name' => 'Family Set A',
                'description' => 'Paket sushi box 24 pcs (Mix Rolls & Nigiri)',
                'price' => 150000,
                'category' => 'Party',
                'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400',
                'tags' => ['Paket', 'Hemat', 'Banyak'],
            ],
            [
                'name' => 'Party Platter',
                'description' => 'Platter besar 40 pcs untuk pesta',
                'price' => 250000,
                'category' => 'Party',
                'image' => 'https://images.unsplash.com/photo-1553621042-f6e147245754?w=400',
                'tags' => ['Pesta', 'Jumbo'],
            ],

            // 7. Beverages
            [
                'name' => 'Ocha (Hot/Cold)',
                'description' => 'Teh hijau tawar (Refill)',
                'price' => 10000,
                'category' => 'Beverages',
                'image' => 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?w=400',
                'tags' => ['Minuman', 'Teh'],
            ],
            [
                'name' => 'Lemon Tea',
                'description' => 'Es teh lemon segar',
                'price' => 15000,
                'category' => 'Beverages',
                'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=400',
                'tags' => ['Minuman', 'Segar'],
            ],
             [
                'name' => 'Soft Drink',
                'description' => 'Cola / Sprite / Fanta',
                'price' => 12000,
                'category' => 'Beverages',
                'image' => 'https://images.unsplash.com/photo-1581636625402-29b2a704ef13?w=400',
                'tags' => ['Minuman', 'Soda'],
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
