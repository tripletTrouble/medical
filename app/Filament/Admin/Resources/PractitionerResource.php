<?php

namespace App\Filament\Admin\Resources;

use App\Map\SexMap;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Polyclinic;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Practitioner;
use App\Map\PractitionerRegMap;
use App\Map\PractitionerTypeMap;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PractitionerResource\Pages;
use App\Filament\Admin\Resources\PractitionerResource\RelationManagers;

class PractitionerResource extends Resource
{
    protected static ?string $model = Practitioner::class;

    protected static ?string $modelLabel = 'Tenaga Kesehatan';

    protected static ?string $navigationIcon = 'healthicons-f-doctor-male';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->label('Jenis')
                    ->options(PractitionerTypeMap::forSelect())
                    ->disablePlaceholderSelection()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, $state) => $set('registration_type', $state))
                    ->default(1),
                TextInput::make('first_name')->label('Nama Depan')->required(),
                TextInput::make('last_name')->label('Nama Belakang')->required(),
                TextInput::make('identity_number')->label('NIK')->required(),
                Grid::make([
                        'default' => 6
                    ])
                    ->schema([
                        Select::make('registration_type')
                            ->label('Jenis')
                            ->options(PractitionerRegMap::forSelect())
                            ->default(1)
                            ->disablePlaceholderSelection()
                            ->disableOptionWhen(function (Get $get, $value) {
                                if ($get('type') == '1') {
                                    return $value == '2';
                                }

                                return $value == '1';
                            })
                            ->live()
                            ->columnSpan(2),
                        TextInput::make('registration_number')
                            ->label('Nomor')
                            ->required()
                            ->columnSpan(4)
                    ])
                    ->columnSpan(1),
                CheckboxList::make('polyclinics')
                        ->label('Poliklinik')
                        ->relationship(
                            'polyclinics',
                            'name',
                            fn(Builder $query): Builder => $query->limit(6)
                            )
                        ->searchable(fn () => DB::table('polyclinics')->count() > 6)
                        ->columns([
                            'default' => 2
                        ]),
                Section::make('Informasi Lain')
                ->schema([
                        Select::make('user_id')
                            ->label('Associated User')
                            ->options(User::all()->pluck('name', 'id'))
                            ->optionsLimit(7)
                            ->searchable(),
                        TextInput::make('details.ihs_number')
                            ->label('IHS Number'),
                        TextInput::make('details.prefix')
                            ->label('Gelar Depan'),
                        Select::make('details.sex.code')
                            ->label('Jenis Kelamin')
                            ->options(SexMap::forSelect())
                            ->disablePlaceholderSelection(),
                        TextInput::make('details.suffix')
                            ->label('Gelar Belakang'),
                        TextInput::make('details.telephone.home')
                            ->label('Telepon Rumah')
                            ->default('+62')
                            ->tel(),
                        TextInput::make('details.telephone.cellular')
                            ->label('HP')
                            ->default('+62')
                            ->tel(),
                        Textarea::make('details.address')
                            ->label('Alamat')
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->state(function (Practitioner $practitioner) {
                        return "{$practitioner->first_name} {$practitioner->last_name}, {$practitioner->details['prefix']} {$practitioner->details['suffix']}";
                    })
                    ->wrap(),
                TextColumn::make('polyclinics.name')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('registration_number')
                    ->label('No. SIP/STR')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hidden(fn(Practitioner $practitioner) => $practitioner->trashed()),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPractitioners::route('/'),
            'create' => Pages\CreatePractitioner::route('/create'),
            'edit' => Pages\EditPractitioner::route('/{record}/edit'),
        ];
    }
}
