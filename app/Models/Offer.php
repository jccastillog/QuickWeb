<?php

// app/Models/Offer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'product_id',
        'title',
        'description',
        'discount',
        'discount_amount',
        'start_date',
        'end_date',
        'type',
        'promo_code',
        'image_path',
        'active'
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación polimórfica para imagen
    public function image()
    {
        return $this->morphOne(Mediable::class, 'mediable')
            ->where('collection', 'offer_image');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Precio resultante de aplicar esta oferta a un precio base.
     * "Compra X lleva Y" no modifica el precio unitario.
     */
    public function applyTo($price): float
    {
        $price = (float) $price;

        $result = match (true) {
            $this->type === 'buy_x_get_y' => $price,
            $this->type === 'fixed_amount' && $this->discount_amount > 0 => $price - $this->discount_amount,
            $this->discount > 0 => $price * (1 - $this->discount / 100),
            $this->discount_amount > 0 => $price - $this->discount_amount,
            default => $price,
        };

        return max(0, round($result, 2));
    }

    // Accesores
    public function getDiscountValueAttribute()
    {
        if ($this->discount) {
            return $this->discount . '%';
        } elseif ($this->discount_amount) {
            return '$' . number_format($this->discount_amount, 2);
        }
        return null;
    }

    public function getStatusAttribute()
    {
        if (!$this->active) return 'Inactiva';
        if (now() < $this->start_date) return 'Programada';
        if (now() > $this->end_date) return 'Expirada';
        return 'Activa';
    }
}