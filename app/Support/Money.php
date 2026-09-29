<?php

namespace App\Support;

class Money
{
    /**
     * Formato de pesos colombianos: $12.500
     */
    public static function format($amount): string
    {
        return '$' . number_format((float) $amount, 0, ',', '.');
    }
}
