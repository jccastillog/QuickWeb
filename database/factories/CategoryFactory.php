<?php

namespace Database\Factories;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Category::class;
    public function definition(): array
    {
        $name = $this->faker->unique()->word;

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph,
            'order' => $this->faker->numberBetween(1, 100),
            'featured' => $this->faker->boolean(20),
            'client_id' => \App\Models\Client::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Category $category) {
            // Crear y asociar media después de crear la categoría
            $media = Media::factory()->create(['client_id' => $category->client_id]);
            
            $category->image()->create([
                'media_id' => $media->id,
                'collection' => 'category_image',
                'custom_properties' => [
                    'alt_text' => 'Imagen de categoría ' . $category->name,
                ]
            ]);
        });
    }
}
