<?php

// app/Models/SiteSettings.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'phone',
        'whatsapp',
        'email',
        'street_address',
        'city',
        'state',
        'country',
        'postal_code',
        'about_text',
        'business_hours',
        'meta_title',
        'meta_description',
        'google_analytics_id'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}