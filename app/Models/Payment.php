<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const METHODS = [
        'nequi' => 'Nequi',
        'daviplata' => 'Daviplata',
        'transferencia' => 'Transferencia bancaria',
        'efectivo' => 'Efectivo',
        'otro' => 'Otro',
    ];

    public const MONTH_OPTIONS = [1, 3, 6, 12];

    protected $fillable = [
        'client_id',
        'plan_id',
        'recorded_by',
        'amount',
        'months',
        'method',
        'reference',
        'paid_at',
        'period_start',
        'period_end',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'months' => 'integer',
        'paid_at' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Accesores
    public function getMethodLabelAttribute(): string
    {
        return self::METHODS[$this->method] ?? ucfirst($this->method);
    }
}
