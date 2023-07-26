<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\Store;
use App\Http\Requests\Tasks\Update;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::query()->withAll();
        $perPage = request()?->query('perPage');

        $tasks = ($perPage ? $tasks->paginate($perPage) : $tasks->paginate())->withQueryString();

        return view('crm.admin.tasks.index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crm.admin.tasks.create', [
            'projects' => Project::all(),
            'users' => User::all(),
            'statuses' => TaskStatus::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        /** @var Task $task */
        $task = Task::factory()->create($request->safe()->except('image'));
        $task->addMediaFromRequest('image')->toMediaCollection(Task::MEDIA_GALLERY_KEY);
        return to_route('tasks.show', $task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('crm.admin.tasks.show', [
            'task' => $task->loadMissing(['user', 'status', 'project']),
            'projects' => Project::all(),
            'users' => User::all(),
            'statuses' => TaskStatus::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('crm.admin.tasks.edit', [
            'task' => $task->loadMissing(['user', 'status', 'project']),
            'projects' => Project::all(),
            'users' => User::all(),
            'statuses' => TaskStatus::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Task $task)
    {
        $task->update($request->safe()->except('image'));
        $task->addMediaFromRequest('image')->toMediaCollection(Task::MEDIA_GALLERY_KEY);
        return to_route('tasks.show', $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return to_route('tasks.index');
    }
}
