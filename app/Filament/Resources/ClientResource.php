<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\User;
use App\Models\UserRoles;
use App\Services\CountryProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Client';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->role(UserRoles::CLIENT->value);
    }

    public static function form(Form $form): Form
    {
        match ($form->getOperation()) {
            'create' => $formTitle = __('Create new project'),
            'edit' => $formTitle = __('Update project')
        };

        return $form
            ->schema([
                Forms\Components\Section::make($formTitle)->schema([
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\TextInput::make('email'),
                    Forms\Components\TextInput::make('phone'),
                    Forms\Components\Select::make('country_id')
                        ->label(__('Country'))
                        ->options((new CountryProvider())->getCountries()->pluck('name', 'code'))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vat')
                    ->label(__('VAT'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->authorize('manage clients'),
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
            'index' => Pages\ListClients::route('/'),
        ];
    }
}
