<?php

namespace Database\Factories;
use App\Models\SiteSettings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SiteSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'street_address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'about_text' => $this->faker->paragraphs(3, true),
            'business_hours' => 'Lunes a Viernes: 9:00 - 18:00',
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph,
        ];
    }
}
