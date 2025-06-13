<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();

        $clients->each(function ($client) {
            $testimonials = Testimonial::factory()
                ->count(2)
                ->create([
                    'client_id' => $client->id,
                ]);

            // Asignar imágenes a algunos testimonios (50% de probabilidad)
            $testimonials->each(function ($testimonial) {
                if (rand(0, 1)) {
                    $testimonial->testimonialImage()->create([
                        'media_id' => \App\Models\Media::factory()->create()->id,
                        'collection' => 'testimonial_image',
                        'custom_properties' => [
                            'alt_text' => 'Foto de ' . $testimonial->author_name,
                        ]
                    ]);
                }
            });
        });
    }
}
