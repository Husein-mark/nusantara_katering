<?php

namespace Database\Factories;

use App\Models\Courier;
use App\Models\Customer;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id'       => Customer::inRandomOrder()->value('id') ?? Customer::factory(),
            'payment_method_id' => PaymentMethod::inRandomOrder()->value('id') ?? PaymentMethod::factory(),
            'courier_id'        => Courier::inRandomOrder()->value('id') ?? Courier::factory(),
            'status'            => fake()->randomElement([
                'menunggu_pembayaran',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',
            ]),
        ];
    }
}
