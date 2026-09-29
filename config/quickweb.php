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

];
