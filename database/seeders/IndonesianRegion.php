<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndonesianRegion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->saveProvince();
        $this->saveRegency();
        $this->saveDistrict();
        $this->saveVillage();
    }

    private function saveProvince(): void
    {
        DB::table('provinces')->delete();

        $stream = fopen(__DIR__."/csv/provinces.csv", 'r+');

        while ($province = fgetcsv($stream,100)) {
            Province::create([
                'name' => $province[0],
                'code' => $province[1]
            ]);
        }
    }

    private function saveRegency(): void
    {
        $stream = fopen(__DIR__."/csv/regencies.csv", "r+");

        while ($regency = fgetcsv($stream,100)) {
            $name = (strtolower($regency[0]) === 'kota' ? $regency[0] : 'Kab.') . " {$regency[1]}";

            Regency::create([
                'name' => $name,
                'province_code' => $regency[2],
                'code' => $regency[2] . $regency[3],
            ]);
        }
    }

    private function saveDistrict(): void
    {
        $stream = fopen(__DIR__."/csv/districts.csv", "r+");

        while ($district = fgetcsv($stream, 100)) {
            District::create([
                'name' => $district[0],
                'regency_code' => $district[1] . $district[2],
                'code' => $district[1] . $district[2] . $district[3]
            ]);
        }
    }

    private function saveVillage(): void
    {
        $stream = fopen(__DIR__."/csv/villages.csv", "r+");

        while ($village = fgetcsv($stream, 100)) {
            Village::create([
                'district_code' => $village[2] . $village[3] . $village[4],
                'code' => $village[2] . $village[3] . $village[4] . $village[5],
                'name' => $village[1],
                'postal_code' => $village[0]
            ]);
        }

    }
}
