<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();

        $clients->each(function ($client) {
            // Ofertas generales (sin producto asociado)
            Offer::factory()
                ->count(2)
                ->create([
                    'client_id' => $client->id,
                    'product_id' => null,
                ]);

            // Ofertas para productos específicos
            $products = Product::where('client_id', $client->id)
                ->inRandomOrder()
                ->limit(5)
                ->get();

            $products->each(function ($product) use ($client) {
                $offer = Offer::factory()
                    ->create([
                        'client_id' => $client->id,
                        'product_id' => $product->id,
                    ]);

                // Asignar imagen a algunas ofertas
                if (rand(0, 1)) {
                    $offer->image()->create([
                        'media_id' => \App\Models\Media::factory()->create()->id,
                        'collection' => 'offer_image',
                        'custom_properties' => [
                            'alt_text' => 'Oferta especial: ' . $offer->title,
                        ]
                    ]);
                }
            });
        });
    }
}