<?php

namespace Database\Factories;
use App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+3 months');

        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'discount' => $this->faker->optional(0.7)->randomFloat(2, 5, 50),
            'discount_amount' => $this->faker->optional(0.3)->randomFloat(2, 5, 100),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'active' => $this->faker->boolean(80),
        ];
    }
}
