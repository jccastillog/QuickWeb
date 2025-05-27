<?php

// app/Models/Mediable.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mediable extends Model
{
    use HasFactory;
    protected $fillable = [
        'media_id',
        'mediable_type',
        'mediable_id',
        'collection',
        'order',
        'custom_properties'
    ];

    protected $casts = [
        'custom_properties' => 'array'
    ];

    // Relaciones
    public function mediable()
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}