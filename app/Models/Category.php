<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'name',
        'slug',
        'description',
        'order',
        'featured'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'order' => 'integer'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relación polimórfica para imagen
    public function image()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'category_image');
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}