<?php

namespace App\Filament\Resources;

use App\Filament\Actions\CsvExportBulkAction;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Filament\Tables\Actions\ExportCsvBulkAction;
use App\Jobs\ExportTasks;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';


    public static function form(Form $form): Form
    {
        $formTitle = match ($form->getOperation()) {
            'create' => __('Create new task'),
            'edit' => __('Update task'),
            default => ''
        };

        return $form
            ->schema([
                Forms\Components\Section::make($formTitle)->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('Name'))
                        ->maxLength(50),
                    Forms\Components\Select::make('project_id')
                        ->label(__('Assigned to Project'))
                        ->options(Project::query()->pluck('title', 'id'))
                        ->exists(table: Project::class, column: 'id'),
                    Forms\Components\Textarea::make('description')->label(__('Description')),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                        ->image()
                        ->maxSize(1021)
                        ->collection(Task::MEDIA_GALLERY_KEY),
                    Forms\Components\TextInput::make('estimation')
                        ->label(__('Estimation'))
                        ->rules([
                            fn() => static function (string $attribute, $value, Closure $fail) {
                                if (!(str_ends_with($value, 'h') && is_numeric(str_replace('h', '', $value)))) {
                                    $fail(__('You should specify estimation in format like: 2h or 8h'));
                                }
                            }
                        ]),
                    Forms\Components\Select::make('user_id')->label(__('Assigned To'))
                        ->options(User::query()->pluck('name', 'id'))
                        ->exists(User::class, column: 'id'),
                    Forms\Components\Select::make('task_status_id')->label(__('Status'))
                        ->options(TaskStatus::query()->pluck('status', 'id'))
                        ->exists(TaskStatus::class, column: 'id'),
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
                    CsvExportBulkAction::make('csvExport')
                        ->label(__('Export to CSV'))
                        ->modalHeading(fn (): string => __('Export entities to CSV', ['label' => static::getPluralModelLabel()]))
                        ->modalSubmitActionLabel(__('Start'))
                        ->color('primary')
                        ->icon('heroicon-m-wrench-screwdriver')
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-o-wrench-screwdriver')
                        ->action(function (array $ids) {
                            ExportTasks::dispatch($ids);
                            Notification::make()
                                ->title(__('Requested entities were pushed to the queue.'))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
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
