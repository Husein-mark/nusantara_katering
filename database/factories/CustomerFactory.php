<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => fake()->name(),
            'phone'   => '08' . fake()->numerify('##########'),
            'city_id' => City::inRandomOrder()->value('id') ?? City::factory(),
        ];
    }
}
