<?php

namespace Database\Factories;
use App\Models\Mediable;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MediableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collection' => $this->faker->randomElement(['default', 'gallery', 'logo', 'featured']),
            'order' => $this->faker->numberBetween(1, 10),
            'custom_properties' => [
                'alt_text' => $this->faker->sentence,
                'caption' => $this->faker->sentence,
            ],
        ];
    }
}
