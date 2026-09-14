<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    public static array $pool = [
        'Transfer Bank',
        'Kartu Debit/Kredit',
        'QRIS',
        'Tunai (COD)',
        'E-Wallet',
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$pool),
        ];
    }
}
