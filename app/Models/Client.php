<?php

// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_name',
        'domain',
        'logo_path',
        'favicon_path',
        'primary_color',
        'secondary_color',
        'theme',
        'font',
        'active',
        'expires_at'
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime'
    ];

    // Relaciones
    public function siteSettings()
    {
        return $this->hasOne(SiteSettings::class);
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    // Relaciones polimórficas para imágenes
    public function logo()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'logo');
    }

    public function favicon()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'favicon');
    }

    // Helpers
    public function getActiveStatusAttribute()
    {
        return $this->active ? 'Activo' : 'Inactivo';
    }
}