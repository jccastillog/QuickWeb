<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::with('client')->get();

        $categories->each(function ($category) {
            $products = Product::factory()
                ->count(5)
                ->create([
                    'client_id' => $category->client_id,
                    'category_id' => $category->id,
                ]);

            // Asignar imágenes a los productos (3-5 imágenes por producto)
            $products->each(function ($product) {
                $imageCount = rand(3, 5);

                for ($i = 0; $i < $imageCount; $i++) {
                    $product->images()->create([
                        'media_id' => \App\Models\Media::factory()->create()->id,
                        'collection' => 'product_gallery',
                        'order' => $i + 1,
                        'custom_properties' => [
                            'alt_text' => 'Imagen del producto ' . $product->name,
                            'caption' => $i === 0 ? 'Imagen principal' : 'Vista adicional ' . $i,
                        ]
                    ]);
                }
            });
        });
    }
}