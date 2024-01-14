<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['base_price'] = str_replace(',', '.', $data['base_price']);

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['base_price'] = str_replace('.', ',', $data['base_price']);

        return $data;
    }
}
