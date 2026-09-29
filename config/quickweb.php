<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Indicativo de país por defecto
    |--------------------------------------------------------------------------
    |
    | Se antepone a los números de WhatsApp guardados sin indicativo
    | (por ejemplo 3001234567) para construir los enlaces wa.me.
    |
    */

    'default_country_code' => env('QUICKWEB_COUNTRY_CODE', '57'),

    // Longitud de un número nacional sin indicativo (Colombia: 10 dígitos)
    'national_number_length' => (int) env('QUICKWEB_NATIONAL_NUMBER_LENGTH', 10),

    /*
    |--------------------------------------------------------------------------
    | Cobro de planes
    |--------------------------------------------------------------------------
    */

    'billing' => [
        // Desde cuántos días antes del vencimiento la tienda aparece "por vencer"
        'warning_days' => 7,

        // Días en que se envía recordatorio al dueño (positivo: antes; 0: el día; negativo: después)
        'reminder_days' => [7, 1, 0, -3],

        // Días después del vencimiento en que la tienda sigue publicada antes de suspenderse
        'grace_days' => (int) env('QUICKWEB_GRACE_DAYS', 5),
    ],

    // Recibe el resumen diario de tiendas por vencer (si está vacío, se usa el correo de los admin)
    'admin_email' => env('QUICKWEB_ADMIN_EMAIL'),

    // Contacto que ven los dueños de tienda para renovar (número con indicativo, sin +)
    'support_whatsapp' => env('QUICKWEB_SUPPORT_WHATSAPP', '573213086428'),

];
