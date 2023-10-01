<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\BulkAction;

class CsvExportBulkAction extends BulkAction
{
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'ids' => [$this->getTable()->getLivewire()->selectedTableRecords],
             default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        return match ($parameterType) {
            'array' => [$this->getTable()->getLivewire()->selectedTableRecords],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
