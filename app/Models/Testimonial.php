<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id',
        'author_name',
        'author_position',
        'content',
        'rating',
        'order',
        'active'
    ];

    protected $casts = [
        'rating' => 'integer',
        'active' => 'boolean',
        'order' => 'integer'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function testimonialImage()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'testimonial_image')->with('media');
    }

    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function uploadImage($file)
    {
        try {
            // Eliminar imagen anterior si existe
            if ($this->testimonialImage) {
                $this->testimonialImage->delete();
            }

            $path = $file->store('clients/testimonials', 'public');
            
            $media = Media::create([
                'client_id' => $this->client_id,
                'uuid' => Str::uuid()->toString(),
                'type' => 'image',
                'name' => 'Imagen de ' . $this->author_name,
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'full_url' => asset('storage/' . $path),
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'is_approved' => true,
            ]);

            return $this->testimonialImage()->create([
                'media_id' => $media->id,
                'collection' => 'testimonial_image'
            ]);

        } catch (\Exception $e) {
            throw new \Exception("Error al subir la imagen: " . $e->getMessage());
        }
    }
}