<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;

class ImportTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LazyCollection::make(function () {
            $storage = Storage::disk('imports');
            if ($handle = $storage->readStream('tasks.csv')) {
                $csvHeader = fgetcsv($handle);
                while (($line = fgetcsv($handle)) !== false) {
                    yield array_combine($csvHeader, $line);
                }
            }
        })->chunk(100)->each(function (LazyCollection $collection) {
            $collection = $collection->collect();

            $users = User::query();
            $projects = Project::query();
            $statuses = TaskStatus::all(['id', 'status']);
            $collection->pluck('user')->each(function ($userName) use ($users) {
                $users->orWhere('name', $userName);
            });
            $collection->pluck('project')->each(function ($projectName) use ($projects) {
                $projects->orWhere('title', $projectName);
            });
            $users = $users->get(['id', 'name']);
            $projects = $projects->get(['id', 'title']);

            $tasks = $collection->map(function ($task) use ($users, $projects, $statuses) {
                if (($taskUser = $users->firstWhere('name', '===', $task['user']))
                    && ($taskProject = $projects->firstWhere('title', '===', $task['project']))
                    && ($taskStatus = $statuses->firstWhere('status', '===', $task['status']))
                ) {
                    unset($task['user'], $task['project'], $task['status']);
                    $task['user_id'] = $taskUser->id;
                    $task['project_id'] = $taskProject->id;
                    $task['task_status_id'] = $taskStatus->id;

                    return $task;
                }

                return null;
            })->filter(fn($task) => !is_null($task))
                ->each(fn ($task) => Task::updateOrCreate(['title' => $task['title']], $task)); // 20s
            //Task::query()->insert($task) - faster then above 4s
            //Task::query()->upsert($tasks->toArray(), []); -- the fastest 1.6s
        });
    }
}
