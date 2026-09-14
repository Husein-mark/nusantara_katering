<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Urutan di bawah ini WAJIB dijaga karena tabel-tabel berikutnya
     * bergantung (foreign key) pada tabel sebelumnya:
     *
     * cities, categories, payment_methods, couriers  (tidak punya FK)
     *      -> customers (butuh city_id), menus (butuh category_id)
     *      -> orders (butuh customer_id, payment_method_id, courier_id)
     *      -> order_items (butuh order_id, menu_id)
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1. Data master yang tidak punya foreign key
        City::factory(50)->create();
        Category::factory(10)->create();
        PaymentMethod::factory(3)->create();
        Courier::factory(10)->create();

        // 2. Data yang bergantung pada data master di atas
        Menu::factory(150)->create();
        Customer::factory(200)->create();

        // 3. Transaksi utama
        $orders = Order::factory(150)->create();

        // 4. Detail pesanan: setiap order mendapat 3-5 item menu acak
        $menuPrices = Menu::pluck('price', 'id');

        foreach ($orders as $order) {
            $itemCount = rand(3, 5);
            $chosenMenuIds = $menuPrices->keys()->random($itemCount);

            foreach ($chosenMenuIds as $menuId) {
                $qty = rand(1, 4);

                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'menu_id'  => $menuId,
                    'qty'      => $qty,
                    'subtotal' => $menuPrices[$menuId] * $qty,
                ]);
            }
        }
    }
}
