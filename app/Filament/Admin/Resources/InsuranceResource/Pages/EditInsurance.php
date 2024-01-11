<?php

namespace App\Filament\Admin\Resources\InsuranceResource\Pages;

use App\Filament\Admin\Resources\InsuranceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsurance extends EditRecord
{
    protected static string $resource = InsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
