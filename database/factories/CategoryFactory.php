<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Daftar kategori menu katering. Sengaja berjumlah 10 agar cocok
     * dengan jumlah kategori yang diminta pada seeder.
     */
    public static array $pool = [
        'Pembuka',
        'Sup',
        'Nasi',
        'Lauk Utama',
        'Sayur',
        'Penutup',
        'Minuman',
        'Camilan',
        'Prasmanan',
        'Box Meal Premium',
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$pool),
        ];
    }
}
