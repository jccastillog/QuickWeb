<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'barcode',
        'featured',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock' => 'integer',
        'featured' => 'boolean',
        'active' => 'boolean'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    // Oferta vigente más reciente del producto
    public function activeOffer()
    {
        return $this->hasOne(Offer::class)
            ->where('active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->latest('start_date');
    }

    // Relaciones polimórficas para imágenes
    public function image()
    {
        return $this->morphMany(Mediable::class, 'mediable')
            ->where('collection', 'product_gallery')
            ->orderBy('order');
    }

    public function featuredImage()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'product_featured')
            ->orderBy('order');
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // Accesores

    /**
     * Precio a cobrar: aplica la oferta vigente si existe.
     */
    public function getFinalPriceAttribute(): float
    {
        return $this->activeOffer
            ? $this->activeOffer->applyTo($this->price)
            : (float) $this->price;
    }

    /**
     * Precio "antes" para mostrar tachado: precio sin oferta o precio de comparación.
     */
    public function getRegularPriceAttribute(): ?float
    {
        if ($this->final_price < (float) $this->price) {
            return (float) $this->price;
        }

        return $this->has_discount ? (float) $this->compare_price : null;
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getHasDiscountAttribute()
    {
        return !is_null($this->compare_price) && $this->compare_price > $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) return 0;
        return round(($this->compare_price - $this->price) / $this->compare_price * 100);
    }
}
