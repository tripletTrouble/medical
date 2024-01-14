<?php

namespace App\Filament\Admin\Pages;

use App\Models;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Margin extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data;

    protected static ?string $navigationIcon = 'healthicons-f-chart-cured-increasing';

    protected static string $view = 'filament.admin.pages.margin';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Margin Obat')
                ->description('Setting margin obat untuk tiap jenis pembayaran')
                ->schema([
                    TextInput::make('medicine.cash')
                        ->label('Perorangan')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                    TextInput::make('medicine.credit')
                        ->label('Jaminan/Asuransi')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                ])
                ->columnSpan(1),
            Section::make('Margin Tindakan/Layanan')
                ->description('Setting margin tindakan/layanan untuk tiap jenis pembayaran')
                ->schema([
                    TextInput::make('service.cash')
                        ->label('Perorangan')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                    TextInput::make('service.credit')
                        ->label('Jaminan/Asuransi')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                ])
                ->columnSpan(1)

        ])
        ->columns([
            'default' => 1,
            'md' => 2
        ])
        ->statePath('data');
    }

    public function mount()
    {
        $data = [];
        $margins = Models\Margin::where('type_model_id', null)->get();

        foreach ($margins as $margin) {
            if ($margin->type_model === Models\Item::class) {
                if ($margin->factor_model === null) {
                    $data['medicine']['cash'] = $margin->amount*100;
                }else {
                    $data['medicine']['credit'] = $margin->amount*100;
                }
            }else {
                if ($margin->factor_model === null) {
                    $data['service']['cash'] = $margin->amount*100;
                }else {
                    $data['service']['credit'] = $margin->amount*100;
                }
            }
        }

        $this->form->fill($data);
    }

    public function saveMargins()
    {
        foreach($this->data as $data_key => &$margins) {
            foreach($margins as $margin_key => &$margin) {
                if (($data_key === 'medicine')) {
                    $model = Models\Margin::where('type_model', Models\Item::class);
                }else {
                    $model = Models\Margin::where('type_model', Models\Service::class);
                }

                if ($margin_key === 'cash') {
                    $model = $model->where('factor_model', null)->first();
                }else {
                    $model = $model->where('factor_model', Models\Insurance::class)->first();
                }

                if ($model == null) {
                    $model = new Models\Margin;
                    $model->type_model = $data_key === 'medicine' ? Models\Item::class : Models\Service::class;
                }

                $model->type_model_id = null;
                $model->factor_model = $margin_key === 'credit' ? Models\Insurance::class : null;
                $model->factor_model_id = null;
                $model->amount = $margin/100;

                $model->save();
                continue;
            }
        }

        Notification::make('saved')
            ->title('Berhasil')
            ->body('Data berhasil disimpan')
            ->success()
            ->send();
    }
}
