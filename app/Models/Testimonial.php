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

    public function image()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'testimonial_image')->with('media');
    }

    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
