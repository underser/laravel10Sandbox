<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        match ($form->getOperation()) {
            'create' => $formTitle = __('Create new project'),
            'edit' => $formTitle = __('Update project')
        };

        return $form
            ->schema([
                Forms\Components\Section::make($formTitle)->schema([
                    Forms\Components\TextInput::make('title')->label(__('Name')),
                    Forms\Components\Select::make('project_id')->label(__('Assigned to Project'))
                        ->options(Project::all(['title', 'id'])->pluck('title', 'id')),
                    Forms\Components\Textarea::make('description')->label(__('Description')),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                        ->image()
                        ->maxSize(1021)
                        ->collection(Task::MEDIA_GALLERY_KEY),
                    Forms\Components\TextInput::make('estimation')->label(__('Estimation')),
                    Forms\Components\Select::make('user_id')->label(__('Assigned To'))
                        ->options(User::all(['name', 'id'])->pluck('name', 'id')),
                    Forms\Components\Select::make('task_status_id')->label(__('Status'))
                        ->options(TaskStatus::all(['id', 'status'])->pluck('status', 'id'))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimation')
                    ->label(__('Estimation'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Assigned To'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.status')
                    ->label(__('Status'))
                    ->sortable(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
