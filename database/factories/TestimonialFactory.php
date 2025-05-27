<?php

namespace Database\Factories;
use App\Models\Testimonial;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => $this->faker->name,
            'author_position' => $this->faker->jobTitle,
            'content' => $this->faker->paragraphs(2, true),
            'rating' => $this->faker->numberBetween(1, 5),
            'order' => $this->faker->numberBetween(1, 20),
            'active' => $this->faker->boolean(90),
        ];
    }
}
