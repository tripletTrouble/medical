<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PolyclinicResource\Pages;
use App\Filament\Admin\Resources\PolyclinicResource\RelationManagers;
use App\Models\Polyclinic;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolyclinicResource extends Resource
{
    protected static ?string $model = Polyclinic::class;

    protected static ?string $modelLabel = 'Poliklinik';

    protected static ?string $navigationIcon = 'healthicons-f-hospice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Poli'),
                Grid::make([
                    'default' => 2
                ])->schema([
                    Toggle::make('is_active')
                        ->label('Aktif?')
                        ->inline(false),
                    Toggle::make('is_visible')
                        ->label('Tampil?')
                        ->inline(false)
                ])
                ->columnSpan(1)
                ->columnStart(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Poli')->required(),
                ToggleColumn::make('is_visible')->label('Tampil'),
                ToggleColumn::make('is_active')->label('Aktif'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolyclinics::route('/'),
            'create' => Pages\CreatePolyclinic::route('/create'),
            'edit' => Pages\EditPolyclinic::route('/{record}/edit'),
        ];
    }
}
