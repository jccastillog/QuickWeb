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
