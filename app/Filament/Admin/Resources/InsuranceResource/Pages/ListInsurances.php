<?php

namespace App\Filament\Admin\Resources\InsuranceResource\Pages;

use App\Filament\Admin\Resources\InsuranceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsurances extends ListRecords
{
    protected static string $resource = InsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
