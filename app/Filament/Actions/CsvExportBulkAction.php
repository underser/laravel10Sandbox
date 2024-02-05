<?php

namespace App\Filament\Actions;

use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\BulkAction;

class CsvExportBulkAction extends BulkAction
{
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        /** @var ListRecords $livewire */
        $livewire = $this->getLivewire();

        return match ($parameterName) {
            'ids' => [$livewire->selectedTableRecords],
             default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        /** @var ListRecords $livewire */
        $livewire = $this->getLivewire();

        return match ($parameterType) {
            'array' => [$livewire->selectedTableRecords],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
