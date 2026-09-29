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
        'price',
        'product_limit',
        'allows_custom_domain',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'product_limit' => 'integer',
        'allows_custom_domain' => 'boolean',
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
}
