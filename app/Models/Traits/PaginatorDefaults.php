<?php
declare(strict_types=1);

namespace App\Models\Traits;

trait PaginatorDefaults
{
    public const DEFAULT_PER_PAGE = 5;

    public function getPerPage(): int
    {
        return self::DEFAULT_PER_PAGE;
    }
}
