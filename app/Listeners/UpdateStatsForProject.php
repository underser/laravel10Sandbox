<?php

namespace App\Listeners;

use App\Events\ProjectWasCreated;
use App\Models\Stat;

class UpdateStatsForProject
{
    /**
     * Handle the event.
     */
    public function handle(ProjectWasCreated $event): void
    {
        $stat = Stat::query()->first();
        $stat::query()->update([
            'projects_count' => $stat->projects_count + 1
        ]);
    }
}
