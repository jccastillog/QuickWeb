<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SocialNetwork;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SocialNetworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platforms = ['facebook', 'instagram', 'twitter', 'youtube', 'linkedin', 'tiktok', 'whatsapp'];
        $icons = [
            'facebook' => 'bi bi-facebook',
            'instagram' => 'bi bi-instagram',
            'twitter' => 'bi bi-twitter',
            'youtube' => 'bi bi-youtube',
            'linkedin' => 'bi bi-linkedin',
            'tiktok' => 'bi bi-tiktok',
            'whatsapp' => 'bi bi-whatsapp'
        ];

        $platform = $this->faker->randomElement($platforms);

        return [
            'platform' => $platform,
            'url' => 'https://' . $platform . '.com/' . $this->faker->userName,
            'icon_class' => $icons[$platform],
            'order' => $this->faker->numberBetween(1, 10),
            'active' => $this->faker->boolean(80),
        ];
    }
}
