<?php

namespace App\Map;

class OccupationMap extends SelectMap
{
    public static ?array $pool = [
        'Tidak bekerja' => 0,
        'PNS' => 1,
        'TNI/POLRI' => 2,
        'BUMN' => 3,
        'Pegawai Swasta/Wirausaha' => 4,
    ];
}
