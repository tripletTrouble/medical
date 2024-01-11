<?php

namespace App\Filament\Admin\Resources\PolyclinicResource\Pages;

use App\Filament\Admin\Resources\PolyclinicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolyclinics extends ListRecords
{
    protected static string $resource = PolyclinicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
