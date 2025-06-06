<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
        protected $fillable = [
        'client_id',
        'name',
        'slug',
        'description',
        'price',
        'interval',
        'product_limit',
        'storage_limit',
        'active'
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
