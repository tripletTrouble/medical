<?php

namespace App\Map;

class EducationMap extends SelectMap
{
    public static ?array $pool = [
        '0' => 'Tidak sekolah',
        '1' => 'SD',
        '2' => 'SLTP sederajat',
        '3' => 'SLTA sederajat',
        '4' => 'D1-D3 sederajat',
        '5' => 'D4',
        '6' => 'S1',
        '7' => 'S2',
        '8' => 'S3',
    ];
}
