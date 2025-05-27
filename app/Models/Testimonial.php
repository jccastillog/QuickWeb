<?php

// app/Models/Testimonial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'author_name',
        'author_position',
        'content',
        'rating',
        'image_path',
        'order',
        'active'
    ];

    protected $casts = [
        'rating' => 'integer',
        'active' => 'boolean',
        'order' => 'integer'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación polimórfica para imagen
    public function authorImage()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'testimonial_image');
    }

    // Accesores
    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}