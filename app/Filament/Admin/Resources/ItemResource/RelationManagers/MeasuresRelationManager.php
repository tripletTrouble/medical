<?php

namespace App\Filament\Admin\Resources\ItemResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MeasuresRelationManager extends RelationManager
{
    protected static string $relationship = 'measures';
    protected static ?string $title = 'Satuan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('measure')
                    ->label('Nama Satuan')
                    ->required()
                    ->maxLength(255),
                Checkbox::make('main_measure')
                    ->label('Satuan utama')
                    ->live()
                    ->inline(),
                Fieldset::make('Terdiri dari:')
                    ->schema([
                        TextInput::make('scale')
                            ->numeric()
                            ->inputMode('decimal')
                            ->label(false),
                        Select::make('parent_id')
                            ->label(false)
                            ->options(function (RelationManager $livewire) {
                                return $livewire->getOwnerRecord()->measures()->pluck('measure', 'id')->toArray();
                            }),
                    ])
                    ->columnSpan(1)
                    ->columns([
                        'default' => 2
                    ])
                    ->hidden(fn(Get $get) => boolval($get('main_measure')))
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('measure')
            ->columns([
                Tables\Columns\TextColumn::make('measure'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    if ($data['main_measure']) {
                        $data['parent_id'] = null;
                        $data['scale'] = 1;
                    }

                    unset($data['main_measure']);

                    return $data;
                })
                ->createAnother(false)
                ->modalHeading('Buat satuan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
