<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Country extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();
        
        $stream = fopen(__DIR__."/csv/country.csv", 'r+');

        while ($country = fgetcsv($stream)) {
            \App\Models\Country::create([
                'name' => $country[0],
                'code_2' => $country[1],
                'code_3' => $country[2]
            ]);
        }
    }
}
