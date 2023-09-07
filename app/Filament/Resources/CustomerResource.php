<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\User;
use App\Models\UserRoles;
use App\Services\CountryProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Customer';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->role(UserRoles::USER->value);
    }

    public static function form(Form $form): Form
    {
        /** @var CountryProvider $countryProvider */
        $countryProvider = resolve(CountryProvider::class);
        match ($form->getOperation()) {
            'create' => $formTitle = __('Create new project'),
            'edit' => $formTitle = __('Update project')
        };
        return $form
            ->schema([
                Forms\Components\Section::make($formTitle)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('Email')),
                    Forms\Components\TextInput::make('email')
                        ->label(__('Email')),
                    Forms\Components\TextInput::make('phone')
                        ->label(__('Phone')),
                    Forms\Components\Select::make('country_code')
                        ->label(__('Country'))
                        ->options($countryProvider->getCountries()->pluck('name', 'code'))
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
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('country_code')
                    ->label(__('Country'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->authorize('manage users'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->authorize('manage users'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->authorize('manage users'),
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
        $pages = ['index' => Pages\ListCustomers::route('/')];


        // @TODO seams like a filament issue self::authorize always return true
        if (self::authorize('manage users')) {
            $pages = array_merge($pages, [
                'create' => Pages\CreateCustomer::route('/create'),
                'edit' => Pages\EditCustomer::route('/{record}/edit')
            ]);
        }

        return $pages;
    }
}
