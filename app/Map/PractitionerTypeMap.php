<?php

namespace App\Map;

class PractitionerTypeMap extends SelectMap
{
    public static ?array $pool = [
        '1' => 'Perawat/Bidan',
        '2' => 'Dokter'
    ];
}
