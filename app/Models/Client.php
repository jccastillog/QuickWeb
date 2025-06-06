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
        return $this->hasMany(Product::class)->with(['images', 'category', 'offers']);
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

    public function uploadLogo($file)
    {
        if ($this->logo) {
            $this->logo->delete();
        }

        $path = $file->store('clients/logos', 'public');
        $filename = 'logo-' . $this->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        
        $media = Media::create([
            'client_id' => $this->id,
            'uuid' => Str::uuid()->toString(),
            'type' => 'logo',
            'name' => 'Logo de ' . $this->store_name,
            'filename' => $filename,
            'path' => $path,
            'full_url' => asset('storage/' . $path),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'is_approved' => true,
        ]);

        return $this->logo()->create([
            'media_id' => $media->id,
            'collection' => 'logo'
        ]);
    }

        public function uploadFavicon($file)
    {
        if ($this->favicon) {
            $this->favicon->delete();
        }

        $path = $file->store('clients/favicons', 'public');
        $filename = 'favicon-' . $this->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        
        $media = Media::create([
            'client_id' => $this->id,
            'uuid' => Str::uuid()->toString(),
            'type' => 'logo',
            'name' => 'Favicon de ' . $this->store_name,
            'filename' => $filename,
            'path' => $path,
            'full_url' => asset('storage/' . $path),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'is_approved' => true,
        ]);

        return $this->logo()->create([
            'media_id' => $media->id,
            'collection' => 'favicon'
        ]);
    }
}