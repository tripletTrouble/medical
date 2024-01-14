<?php

namespace App\Filament\Admin\Resources\PractitionerResource\Pages;

use App\Map\SexMap;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\PractitionerResource;

class EditPractitioner extends EditRecord
{
    protected static string $resource = PractitionerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['details']['sex']['code']) {
            $data['details']['sex']['text'] = SexMap::getValue($data['details']['sex']['code']);
        }

        return $data;
    }
}
