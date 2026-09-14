<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public static array $names = [
        'Nasi Liwet Komplit', 'Ayam Bakar Bumbu Rujak', 'Rendang Daging Sapi',
        'Sup Iga Bening', 'Sayur Asem Betawi', 'Gado-Gado Spesial',
        'Pepes Ikan Kembung', 'Sate Ayam Madura', 'Soto Ayam Lamongan',
        'Ikan Bakar Kecap', 'Tumis Kangkung Terasi', 'Perkedel Kentang',
        'Es Cendol Durian', 'Puding Lapis Santan', 'Kolak Pisang Ubi',
        'Es Teh Manis', 'Es Jeruk Peras', 'Risoles Mayo',
        'Lumpia Semarang', 'Tahu Isi Sayur', 'Klepon Isi Gula Merah',
        'Nasi Kuning Tumpeng Mini', 'Opor Ayam Kampung', 'Sambal Goreng Kentang Ati',
        'Urap Sayuran', 'Bakso Kuah Rempah', 'Mie Goreng Jawa',
        'Capcay Kuah', 'Kerupuk Udang', 'Acar Timun Wortel',
    ];

    public static array $variants = [
        'Reguler', 'Family Pack', 'Box Individu', 'Porsi Besar', 'Edisi Spesial',
    ];

    /**
     * Nama akhir ditentukan oleh configure() (30 nama dasar x 5 varian = 150
     * kombinasi unik), jadi di sini cukup isi nilai sementara.
     */
    public function definition(): array
    {
        return [
            'name'        => self::$names[0] . ' (' . self::$variants[0] . ')',
            'price'       => fake()->numberBetween(8, 75) * 1000,
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }

    /**
     * Menjamin 150 baris menu punya nama unik: 30 nama dasar dikombinasikan
     * dengan 5 varian, dipetakan lewat index urutan pembuatan (sequence).
     */
    public function configure(): static
    {
        return $this->sequence(function ($sequence) {
            $totalNames = count(self::$names);
            $name = self::$names[$sequence->index % $totalNames];
            $variant = self::$variants[intdiv($sequence->index, $totalNames) % count(self::$variants)];

            return ['name' => "{$name} ({$variant})"];
        });
    }
}
