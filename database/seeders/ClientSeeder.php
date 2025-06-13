<?php

// database/seeders/ClientSeeder.php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Media;
use App\Models\Mediable;
use App\Models\SiteSettings;
use App\Models\SocialNetwork;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Crear 5 clientes con sus configuraciones
        $clients = Client::factory()
            ->count(5)
            ->has(SiteSettings::factory())
            ->has(SocialNetwork::factory()->count(3))
            ->has(Testimonial::factory()->count(3))
            ->create();

        // Asignar imágenes a los clientes
        $clients->each(function ($client) {
            // Crear media asociado al cliente
            $logoMedia = Media::factory()->create([
                'client_id' => $client->id,
                'filename' => 'logo-' . $client->id . '.png',
                'path' => 'logos/logo-' . $client->id . '.png'
            ]);

            $faviconMedia = Media::factory()->create([
                'client_id' => $client->id,
                'filename' => 'favicon-' . $client->id . '.ico',
                'path' => 'favicons/favicon-' . $client->id . '.ico'
            ]);

            // Asociar mediante relación polimórfica
            $client->logo()->create([
                'media_id' => $logoMedia->id,
                'collection' => 'logo',
                'custom_properties' => [
                    'alt_text' => 'Logo de ' . $client->store_name,
                ]
            ]);

            $client->favicon()->create([
                'media_id' => $faviconMedia->id,
                'collection' => 'favicon',
            ]);
        });
    }
}
