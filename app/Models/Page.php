<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'title',
        'slug',
        'content',
        'active',
        'order',
    ];
    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];
    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            $page->slug = Str::slug($page->title);
        });
        
        static::updating(function ($page) {
            $page->slug = Str::slug($page->title);
        });
    }
}
