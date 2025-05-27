<?php

// app/Models/Media.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'filename',
        'path',
        'full_url',
        'mime_type',
        'size',
        'disk'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function mediables()
    {
        return $this->hasMany(Mediable::class);
    }

    // Accesores
    public function getHumanReadableSizeAttribute()
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->size;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units)) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}