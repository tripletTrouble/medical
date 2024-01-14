<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama Lengkap')
                    ->required(),
                TextInput::make('email')->label('E-mail')
                    ->required()
                    ->email(),
                TextInput::make('password')->label('Password')
                    ->password()
                    ->required()
                    ->confirmed(),
                TextInput::make('password_confirmation')->label('Konfirmasi Password')
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Lengkap')
                    ->wrap(),
                TextColumn::make('email')->label('E-mail')
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('assignRoles')
                        ->icon('heroicon-s-user-group')
                        ->fillForm(fn(User $user): array => [
                            'roles' => $user->getRoleNames()->toArray()
                        ])
                        ->form([
                            CheckboxList::make('roles')->label('User Role')
                                ->options(Role::all()->pluck('name', 'name'))
                                ->columns(2),
                        ])
                        ->action(function (array $data, User $user) {
                            $user->assignRole($data['roles']);
                            Notification::make('success')
                                ->title('Berhasil')
                                ->body('User telah diberi role')
                                ->success()
                                ->send();
                        })
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
