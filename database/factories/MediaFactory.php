<?php

namespace Database\Factories;
use App\Models\Media;
use App\Models\Client;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['image/jpeg', 'image/png', 'image/webp'];
        $filename = $this->faker->word . '.' . $this->faker->fileExtension;

        return [
            'client_id' => Client::factory(), // Auto-generar client_id
            'uuid' => $this->faker->uuid,
            'type' => $this->faker->randomElement(['Logo', 'Favicon', 'Banner', 'Thumbnail']),
            'name' => $this->faker->sentence(3), // Nombre descriptivo del archivo
            'filename' => $filename,
            'path' => 'uploads/' . $filename,
            'full_url' => 'https://placeholder.com/' . $filename,
            'mime_type' => $this->faker->randomElement($types),
            'size' => $this->faker->numberBetween(1000, 500000),
            'variations' => json_encode([
                'small' => 'uploads/small_' . $filename,
                'medium' => 'uploads/medium_' . $filename,
                'large' => 'uploads/large_' . $filename,
            ]),
            'disk' => 'public',
            'checksum' => $this->faker->md5,
            'is_approved' => $this->faker->boolean(80), // 80% probabilidad de ser aprobado
        ];
    }
}
