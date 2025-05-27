<?php

// app/Models/SocialNetwork.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialNetwork extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'platform',
        'url',
        'icon_class',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Helpers
    public static function availablePlatforms()
    {
        return [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
            'linkedin' => 'LinkedIn',
            'tiktok' => 'TikTok',
            'whatsapp' => 'WhatsApp'
        ];
    }
}