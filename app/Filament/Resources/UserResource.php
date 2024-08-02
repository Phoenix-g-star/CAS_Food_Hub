<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Tables\Actions\EditAction;
use Tables\Columns\TextColumn;
use Forms\Components\TextInput;
use Filament\Resources\Resource;
use Tables\Actions\BulkActionGroup;
use Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_type')
                    ->options([
                        'Seller' => 'Seller',
                        'Customer' => 'Customer',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('user_type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->user_type === 'Admin';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->user_type === 'Admin';
    }

    public static function canView($record): bool
    {
        return auth()->user()->user_type === 'Admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()->user_type === 'Admin';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->user_type === 'Admin';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->user_type === 'Admin';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->user_type === 'Admin';
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
