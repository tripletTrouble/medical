<?php

namespace App\Map;

class IdentityTypeMap extends SelectMap
{
    public static ?array $pool = [
        '1' => 'KTP',
        '2' => 'SIM',
        '3' => 'Paspor',
        '4' => 'KITAS',
        '5' => 'Lainnya'
    ];
}
