<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_name' => $this->faker->company,
            'domain' => $this->faker->unique()->domainName,
            'primary_color' => $this->faker->hexColor,
            'secondary_color' => $this->faker->hexColor,
            'theme' => $this->faker->randomElement(['light', 'dark']),
            'font' => $this->faker->randomElement(['Arial', 'Roboto', 'Open Sans', 'Montserrat']),
            'active' => $this->faker->boolean(90),
            'expires_at' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}
