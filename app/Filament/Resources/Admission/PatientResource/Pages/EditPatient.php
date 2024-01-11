<?php

namespace App\Filament\Resources\Admission\PatientResource\Pages;

use App\Filament\Resources\Admission\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CreatePatient::completeData($data);
    }
}
