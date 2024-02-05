<?php

namespace App\Filament\Resources;

use App\Exceptions\StateException;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\UserRoles;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        $formTitle = match ($form->getOperation()) {
            'create' => __('Create new project'),
            'edit' => __('Update project'),
            default => ''
        };
        return $form
            ->schema([
                Forms\Components\Section::make($formTitle)->schema([
                    Forms\Components\TextInput::make('title')
                        ->maxLength(50)
                        ->required(),
                    Forms\Components\Textarea::make('description'),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                        ->image()
                        ->maxSize(1021)
                        ->collection(Project::MEDIA_GALLERY_KEY),
                    Forms\Components\DatePicker::make('deadline')
                        ->after('tomorrow'),
                    Forms\Components\Select::make('user_id')
                        ->label(__('Moderator'))
                        ->options(User::role(UserRoles::USER->value)->pluck('name', 'id'))
                        ->exists(table: User::class, column: 'id'),
                    Forms\Components\Select::make('client_id')
                        ->label(__('Client'))
                        ->options(User::role(UserRoles::CLIENT->value)->pluck('name', 'id'))
                        ->exists(table: User::class, column: 'id'),
                    Forms\Components\Select::make('project_status_id')
                        ->label(__('Status'))
                        ->options(ProjectStatus::query()->pluck('status', 'id'))
                        ->exists(table: ProjectStatus::class, column: 'id')
                        ->rules([
                            fn() => static function (string $attribute, $value, Closure $fail) use ($form) {
                                /** @var ?Project $project */
                                $project = $form->getRecord();
                                $requestedProjectStatusName = ProjectStatus::find($value)->status;

                                if ($project->status->status === $requestedProjectStatusName) {
                                    return;
                                }

                                try {
                                    $project?->state()->{Str::camel($requestedProjectStatusName)}();
                                } catch (StateException $e) {
                                    $fail(__('Project cannot be moved to :Status', ['status' => $requestedProjectStatusName]));
                                }
                            }
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->label(__('Deadline Date'))
                    ->dateTime('m/d/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Moderator'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.status')
                    ->label(__('Status'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
