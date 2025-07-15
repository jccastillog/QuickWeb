<?php

// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_name',
        'domain',
        'primary_color',
        'secondary_color',
        'theme',
        'font',
        'timezone',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->with('image');
    }

    public function products()
    {
        return $this->hasMany(Product::class)->with(['image', 'category', 'offers']);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    // Relaciones polimórficas para imágenes
    public function logo()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'logo')->with('media');
    }

    public function favicon()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'favicon')->with('media');
    }

    // Helpers
    public function getActiveStatusAttribute()
    {
        return $this->active ? 'Activo' : 'Inactivo';
    }

    public function getUrlAttribute(): string
    {
        if ($this->custom_domain) {
            return 'https://' . $this->custom_domain;
        }

        return app()->environment('local')
            ? 'http://127.0.0.1:8000/' . $this->domain
            : 'https://' . $this->domain . '.quickweb.com.co';
    }
}
