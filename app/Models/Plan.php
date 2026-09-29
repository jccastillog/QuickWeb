<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'price',
        'product_limit',
        'allows_custom_domain',
        'highlighted',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'product_limit' => 'integer',
        'allows_custom_domain' => 'boolean',
        'highlighted' => 'boolean',
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relaciones
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    // Accesores
    public function getProductLimitLabelAttribute(): string
    {
        return $this->product_limit === null ? 'Ilimitados' : (string) $this->product_limit;
    }

    /**
     * Características para la landing: primero las que salen de los límites del plan,
     * luego las escritas a mano (una por línea).
     */
    public function getFeatureListAttribute(): array
    {
        $generated = [
            $this->product_limit === null ? 'Productos ilimitados' : "Hasta {$this->product_limit} productos",
            $this->allows_custom_domain
                ? 'Tu propio dominio (tunegocio.com)'
                : 'Dirección tunegocio.quickweb.com.co',
        ];

        $custom = preg_split('/\r\n|\r|\n/', (string) $this->features);

        return array_values(array_filter(array_map('trim', [...$generated, ...$custom])));
    }
}
