<?php

namespace App\Filament\Resources\Admission;

use App\Map\SexMap;
use Filament\Forms;
use Filament\Tables;
use App\Models\Country;
use App\Models\Patient;
use App\Models\Regency;
use App\Models\Village;
use Filament\Forms\Get;
use App\Map\MarriageMap;
use App\Map\ReligionMap;
use App\Models\District;
use App\Models\Province;
use Filament\Forms\Form;
use App\Map\EducationMap;
use App\Map\OccupationMap;
use Filament\Tables\Table;
use App\Map\IdentityTypeMap;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admission\PatientResource\Pages;
use App\Filament\Resources\Admission\PatientResource\RelationManagers;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $modelLabel = 'pasien';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->label('Nama Depan')->required(),
                TextInput::make('last_name')->label('Nama Belakang')->required(),
                TextInput::make('pob')->label('Tempat Lahir'),
                DatePicker::make('dob')->label('Tanggal Lahir')->maxDate(date('Y-m-d')),
                TextInput::make('guardian_name')->label('Nama Ibu Kandung'),
                Grid::make([
                    'default' => 1,
                    'md' => 2
                ])->schema([
                    Select::make('details.sex.code')->label('Jenis Kelamin')
                        ->options(SexMap::forSelect())->default('1'),
                    TextInput::make('details.preposition')->label('Preposisi')
                        ->datalist([
                            'Nn.',
                            'Tn.',
                            'Ny.',
                            'Sdr.',
                            'Sdri.',
                            'An.',
                            'By.'
                        ])
                ])->columnSpan(1),
                TextInput::make('details.religion.text')->label('Agama')
                    ->datalist(array_keys(ReligionMap::forSelect())),
                TextInput::make('details.telephone.home')->label('Telepon Rumah')
                    ->default('+62')
                    ->tel(),
                TextInput::make('details.telephone.cellular')->label('HP')
                    ->default('+62')
                    ->tel(),
                Select::make('details.education.code')->label('Pendidikan Terakhir')
                    ->options(EducationMap::forSelect())->default(1)->disablePlaceholderSelection(),
                TextInput::make('details.occupation.text')->label('Pekerjaan')
                    ->datalist(array_keys(OccupationMap::forSelect())),
                Select::make('details.marriage.code')->label('Status Pernikahan')
                    ->options(MarriageMap::forSelect())->default(1)->disablePlaceholderSelection(),
                Select::make('identity_type')->label('Jenis Identitas')
                    ->options(IdentityTypeMap::forSelect())->default(1)->disablePlaceholderSelection(),
                TextInput::make('identity_number')->label('Nomor Identitas'),
                TextInput::make('details.ethnic')->label('Suku Bangsa'),
                TextInput::make('details.language')->label('Bahasa yg Dikuasai')->default('Indonesia'),
                Section::make('Alamat Sesuai KTP')
                    ->schema([
                        TextInput::make('details.address.line')
                            ->label('Alamat')
                            ->helperText('Lengkap dengan jalan/gang')
                            ->columnSpan(2),
                        TextInput::make('details.address.rt')
                            ->label('RT')
                            ->maxLength(3)
                            ->minLength(3)
                            ->columnSpan(1),
                        TextInput::make('details.address.rw')
                            ->label('RW')
                            ->maxLength(3)
                            ->minLength(3)
                            ->columnSpan(1),
                        Select::make('details.address.country.code')
                            ->label('Negara')
                            ->options(Country::all()->pluck('name', 'code_3'))
                            ->optionsLimit(7)
                            ->searchable()
                            ->default('IDN')
                            ->disablePlaceholderSelection()
                            ->columnSpan(2),
                        Select::make('details.address.province.code')
                            ->label('Provinsi')
                            ->options(Province::all()->pluck('name', 'code'))
                            ->optionsLimit(7)
                            ->searchable()
                            ->disablePlaceholderSelection()
                            ->default('11')
                            ->live()
                            ->columnSpan(2),
                        Select::make('details.address.regency.code')
                            ->label('Kabupaten/Kota')
                            ->options(function (Get $get): array {
                                if ($get('details.address.province.code')) {
                                    return Regency::where('province_code', $get('details.address.province.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->disablePlaceholderSelection()
                            ->columnSpan(2),
                        Select::make('details.address.district.code')
                            ->label('Kecamatan')
                            ->options(function (Get $get): array {
                                if ($get('details.address.regency.code')) {
                                    return District::where('regency_code', $get('details.address.regency.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->disablePlaceholderSelection()
                            ->columnSpan(2),
                        Select::make('details.address.village.code')
                            ->label('Desa/Kelurahan')
                            ->options(function (Get $get): array {
                                if ($get('details.address.district.code')) {
                                    return Village::where('district_code', $get('details.address.district.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->disablePlaceholderSelection()
                            ->columnSpan(2),
                    ])->columns([
                        'default' => 2,
                        'md' => 4
                    ]),
                Section::make('Alamat Domisili')
                    ->description('Kosongi jika sama dengan alamat KTP')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('details.domicile.line')->label('Alamat')->helperText('Lengkap dengan jalan/gang')->columnSpan(2),
                        TextInput::make('details.domicile.rt')->label('RT')->columnSpan(1),
                        TextInput::make('details.domicile.rw')->label('RW')->columnSpan(1),
                        Select::make('details.domicile.country.code')
                            ->label('Negara')
                            ->options(Country::all()->pluck('name', 'code_3'))
                            ->optionsLimit(7)
                            ->searchable()
                            ->columnSpan(2),
                        Select::make('details.domicile.province.code')
                            ->label('Provinsi')
                            ->options(Province::all()->pluck('name', 'code'))
                            ->optionsLimit(7)
                            ->searchable()
                            ->live()
                            ->columnSpan(2),
                        Select::make('details.domicile.regency.code')
                            ->label('Kabupaten/Kota')
                            ->options(function (Get $get): array {
                                if ($get('details.domicile.province.code')) {
                                    return Regency::where('province_code', $get('details.domicile.province.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->columnSpan(2),
                        Select::make('details.domicile.district.code')
                            ->label('Kecamatan')
                            ->options(function (Get $get): array {
                                if ($get('details.domicile.regency.code')) {
                                    return District::where('regency_code', $get('details.domicile.regency.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->columnSpan(2),
                        Select::make('details.domicile.village.code')
                            ->label('Desa/Kelurahan')
                            ->options(function (Get $get): array {
                                if ($get('details.domicile.district.code')) {
                                    return Village::where('district_code', $get('details.domicile.district.code'))
                                        ->get()
                                        ->pluck('name', 'code')
                                        ->toArray();
                                }

                                return [];
                            })
                            ->optionsLimit(7)
                            ->searchable()
                            ->columnSpan(2),
                    ])->columns([
                        'default' => 2,
                        'md' => 4
                    ]),
                Section::make('Penanggung Jawab')
                    ->schema([
                        TextInput::make('details.responsible.relation')->label('Hubungan dg Pasien')
                            ->datalist(['Ibu', 'Ayah', 'Kakak', 'Adik', 'Suami', 'Istri']),
                        TextInput::make('details.responsible.name')->label('Nama Lengkap'),
                        TextInput::make('details.responsible.phone')->label('Nomor Telepon/HP')
                            ->default('+62')
                            ->tel(),
                        Textarea::make('details.responsible.address')->label('Alamat')->rows(3),
                    ])->columns([
                        'default' => 1,
                        'md' => 2
                    ])
            ])->columns([
                'default' => 1,
                'md' => 2
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pasien')
                    ->state(function (Patient $patient): string {
                        return "{$patient->first_name} {$patient->last_name}, {$patient->details['preposition']}";
                    })
                    ->wrap(),
                TextColumn::make('rekmed')
                    ->state(function (Patient $patient): string {
                        return str($patient->id)->padLeft(6, '0');
                    }),
                TextColumn::make('identity_number')
                    ->label('No. Identitas')
                    ->visibleFrom('md'),
                TextColumn::make('dob')->label('Tanggal Lahir')->dateTime('Y-m-d')
                    ->wrap()->visibleFrom('md'),
                TextColumn::make('details.telephone.cellular')
                    ->label('No. HP')->visibleFrom('md')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                Filter::make('rekmed')
                    ->form([
                        TextInput::make('rekmed')->label('No. Rekam Medis')
                            ->debounce(750)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['rekmed'],
                            fn($query): Builder =>  $query->where('id', $data['rekmed'])
                        );
                    }),
                Filter::make('search')
                    ->form([
                        TextInput::make('search')->label('Pencarian')
                            ->debounce(750)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['search'],
                            fn($query): Builder =>  $query->whereFulltext(['first_name', 'last_name', 'identity_number', 'guardian_name'], $data['search'], ['mode' => 'boolean'])
                        );
                    })
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
