<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
// database/seeders/CategorySeeder.php

    public function run()
    {
        // Asegúrate que existan clientes primero
        if (\App\Models\Client::count() === 0) {
            $this->call(ClientSeeder::class);
        }

        Category::withoutEvents(function () {
            $clients = \App\Models\Client::all();

            $clients->each(function ($client) {
                Category::factory()
                    ->count(8)
                    ->create([
                        'client_id' => $client->id,
                    ]);
            });
        });
    }
}