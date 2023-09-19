<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Collection $records)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Storage::disk('exports'); // Makes sure that disk directory created.
        $filename = 'tasks_export_' . now()->timestamp . '.csv';
        $stream = fopen(storage_path('exports/' . $filename), 'wb');

        fputcsv($stream, ['title', 'description', 'estimation', 'user', 'project', 'status']);
        $this->records->each(function (Task $record) use ($stream) {
            fputcsv($stream, [
                $record->title,
                $record->description,
                $record->getAttributes()['estimation'],
                $record->user->name,
                $record->project->title,
                $record->status->status
            ]);
        });
    }
}
