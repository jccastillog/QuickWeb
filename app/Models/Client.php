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
        'custom_domain',
        'plan_id',
        'primary_color',
        'secondary_color',
        'theme',
        'font',
        'timezone',
        'active',
        'expires_at'
    ];

    protected $hidden = [
        'user_id',
        'expires_at',
        'deleted_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
        'billing_reminder_sent_on' => 'date',
    ];

    public const BILLING_STATUSES = [
        'sin_vencimiento' => ['label' => 'Sin vencimiento', 'color' => 'secondary'],
        'al_dia' => ['label' => 'Al día', 'color' => 'success'],
        'por_vencer' => ['label' => 'Por vencer', 'color' => 'warning'],
        'en_gracia' => ['label' => 'Vencida (en gracia)', 'color' => 'danger'],
        'suspendida' => ['label' => 'Suspendida', 'color' => 'dark'],
    ];

    // Relaciones
    public function siteSettings()
    {
        return $this->hasOne(SiteSettings::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(Product::class)->with(['image', 'category', 'offers']);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->latest('paid_at')->latest('id');
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

    public function getUrlAttribute(): string
    {
        if ($this->custom_domain && app()->environment('production')) {
            return 'https://' . $this->custom_domain;
        }

        return app()->environment('production')
            ? 'https://' . $this->domain . '.quickweb.com.co'
            : url($this->domain);
    }

    /**
     * URL pública de una sección de la tienda, ej: storeUrl('producto/camiseta')
     */
    public function storeUrl(string $path = ''): string
    {
        return rtrim($this->url, '/') . ($path !== '' ? '/' . ltrim($path, '/') : '');
    }

    // Facturación

    /**
     * Días que faltan para el vencimiento (negativo si ya venció); null si no vence.
     */
    public function daysUntilExpiry(): ?int
    {
        if (!$this->expires_at) {
            return null;
        }

        return (int) now()->startOfDay()->diffInDays($this->expires_at->copy()->startOfDay(), false);
    }

    public function billingStatus(): string
    {
        $days = $this->daysUntilExpiry();

        return match (true) {
            $days === null => 'sin_vencimiento',
            $days > config('quickweb.billing.warning_days') => 'al_dia',
            $days >= 0 => 'por_vencer',
            $days >= -config('quickweb.billing.grace_days') => 'en_gracia',
            default => 'suspendida',
        };
    }

    public function billingStatusLabel(): string
    {
        return self::BILLING_STATUSES[$this->billingStatus()]['label'];
    }

    public function billingStatusColor(): string
    {
        return self::BILLING_STATUSES[$this->billingStatus()]['color'];
    }

    public function isSuspended(): bool
    {
        return $this->billingStatus() === 'suspendida';
    }

    /**
     * Fecha a partir de la cual la tienda se suspende si no paga.
     */
    public function suspendsOn(): ?\Illuminate\Support\Carbon
    {
        return $this->expires_at?->copy()->startOfDay()->addDays(config('quickweb.billing.grace_days') + 1);
    }

    /**
     * Límite de productos según el plan; sin plan o plan ilimitado no hay límite.
     */
    public function productLimit(): ?int
    {
        return $this->plan?->product_limit;
    }

    public function canAddProducts(): bool
    {
        $limit = $this->productLimit();

        return $limit === null || $this->products()->count() < $limit;
    }
}
