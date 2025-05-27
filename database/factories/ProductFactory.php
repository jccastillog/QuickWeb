<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'compare_price' => $this->faker->optional(0.7)->randomFloat(2, 10, 600),
            'stock' => $this->faker->numberBetween(0, 200),
            'sku' => $this->faker->unique()->bothify('SKU-####-???'),
            'barcode' => $this->faker->unique()->ean13,
            'featured' => $this->faker->boolean(20),
            'active' => $this->faker->boolean(90),
        ];
    }
}
