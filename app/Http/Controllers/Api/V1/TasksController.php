<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tasks\Store;
use App\Http\Requests\Api\V1\Tasks\Update;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::query()->withAll();
        $filters = array_filter($request->only(['id', 'title', 'description']));
        $tasks->when(count($filters), function (Builder $query) use ($filters) {
            collect($filters)->each(
                fn($filterValue, $filterName) => $query->where($filterName, 'like', '%'. $filterValue . '%')
            );
        });
        return TaskResource::collection($tasks->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        /** @var Task $task */
        $task = Task::factory()->create($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $task->addMediaFromRequest('image')->toMediaCollection(Task::MEDIA_GALLERY_KEY);
        }

        return new TaskResource($task->loadMissing(['project', 'status', 'user']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task->loadMissing(['project', 'status', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Task $task)
    {
        $task->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $task->addMediaFromRequest('image')->toMediaCollection(Task::MEDIA_GALLERY_KEY);
        }

        return new TaskResource($task->loadMissing(['project', 'status', 'user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->checkUserAbility('manage tasks');

        $task->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
