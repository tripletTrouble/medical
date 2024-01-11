<?php

namespace App\Filament\Resources\Admission\PatientResource\Pages;

use App\Filament\Resources\Admission\PatientResource;
use App\Models;
use App\Map;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return self::completeData($data);
    }

    public static function completeData(array $data): array
    {
        if ($data['details']['sex']['code']) {
            $data['details']['sex']['text'] = Map\SexMap::getValue($data['details']['sex']['code']);
        }

        if ($data['details']['religion']['text']) {
            $data['details']['religion']['code'] = Map\ReligionMap::getValue($data['details']['religion']['text']) ?? '8';
        }

        if ($data['details']['education']['code']) {
            $data['details']['education']['text'] = Map\EducationMap::getValue($data['details']['education']['code']);
        }

        if ($data['details']['occupation']['text']) {
            $data['details']['occupation']['code'] = Map\OccupationMap::getValue($data['details']['occupation']['text']) ?? '5';
        }

        if ($data['details']['marriage']['code']) {
            $data['details']['marriage']['text'] = Map\MarriageMap::getValue($data['details']['marriage']['code']);
        }

        if ($data['details']['address']['country']['code']) {
            $data['details']['address']['country']['text'] = Models\Country::where('code_3', $data['details']['address']['country']['code'])->first()?->name;
        }

        if ($data['details']['address']['province']['code']) {
            $data['details']['address']['province']['text'] = Models\Province::where('code', $data['details']['address']['province']['code'])->first()?->name;
        }

        if ($data['details']['address']['regency']['code']) {
            $data['details']['address']['regency']['text'] = Models\Regency::where('code', $data['details']['address']['regency']['code'])->first()?->name;
        }
        
        if ($data['details']['address']['district']['code']) {
            $data['details']['address']['district']['text'] = Models\District::where('code', $data['details']['address']['district']['code'])->first()?->name;
        }
        
        if ($data['details']['address']['village']['code']) {
            $village = Models\Village::where('code', $data['details']['address']['village']['code'])->first();

            $data['details']['address']['village']['text'] = $village?->name;
            $data['details']['address']['postalcode'] = $village?->postal_code;
        }

        if ($data['details']['domicile']['country']['code']) {
            $data['details']['domicile']['country']['text'] = Models\Country::where('code_3', $data['details']['domicile']['country']['code'])->first()?->name;
        }

        if ($data['details']['domicile']['province']['code']) {
            $data['details']['domicile']['province']['text'] = Models\Province::where('code', $data['details']['domicile']['province']['code'])->first()?->name;
        }

        if ($data['details']['domicile']['regency']['code']) {
            $data['details']['domicile']['regency']['text'] = Models\Regency::where('code', $data['details']['domicile']['regency']['code'])->first()?->name;
        }
        
        if ($data['details']['domicile']['district']['code']) {
            $data['details']['domicile']['district']['text'] = Models\District::where('code', $data['details']['domicile']['district']['code'])->first()?->name;
        }
        
        if ($data['details']['domicile']['village']['code']) {
            $village = Models\Village::where('code', $data['details']['domicile']['village']['code'])->first();

            $data['details']['domicile']['village']['text'] = $village?->name;
            $data['details']['domicile']['postalcode'] = $village?->postal_code;
        }

        return $data;
    }
}
