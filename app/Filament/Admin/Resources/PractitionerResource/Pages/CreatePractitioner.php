<?php

namespace App\Filament\Admin\Resources\PractitionerResource\Pages;

use Map\SexMap;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\PractitionerResource;

class CreatePractitioner extends CreateRecord
{
    protected static string $resource = PractitionerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['details']['sex']['code']) {
            $data['details']['sex']['text'] = SexMap::getValue($data['details']['sex']['code']);
        }

        return $data;
    }
}
