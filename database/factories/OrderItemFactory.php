<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first();
        $qty = fake()->numberBetween(1, 5);

        return [
            'order_id' => Order::inRandomOrder()->value('id') ?? Order::factory(),
            'menu_id'  => $menu?->id ?? Menu::factory(),
            'qty'      => $qty,
            'subtotal' => $menu ? $menu->price * $qty : 0,
        ];
    }
}
