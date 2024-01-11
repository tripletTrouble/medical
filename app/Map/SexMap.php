<?php

namespace App\Map;

class SexMap extends SelectMap
{
    public static ?array $pool = [
        '0' => 'Tidak diketahui',
        '1' => 'Laki-laki',
        '2' => 'Perempuan',
        '3' => 'Tidak dapat ditentukan',
        '4' => 'Tidak mengisi',
    ];
}
