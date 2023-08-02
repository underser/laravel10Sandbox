<?php

namespace App\Http\Controllers;

use App\Exceptions\StateException;
use App\Http\Requests\Projects\Store;
use App\Http\Requests\Projects\Update;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\UserRoles;
use App\Notifications\ProjectCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::query()->withAll();
        $perPage = request()?->query('perPage');

        $projects = ($perPage ? $projects->paginate($perPage) : $projects->paginate())->withQueryString();

        return view('crm.admin.projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserAbility('manage projects');

        return view('crm.admin.projects.create', [
            'clients' => User::role(UserRoles::CLIENT->value)->get(),
            'users' => User::role(UserRoles::USER->value)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $this->checkUserAbility('manage projects');

        /** @var Project $project */
        $project = Project::factory()->create($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')->toMediaCollection(Project::MEDIA_GALLERY_KEY);
        }

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('crm.admin.projects.show', [
            'project' => $project->loadMissing(['user', 'client', 'status']),
            'clients' => User::role(UserRoles::CLIENT->value)->get(),
            'users' => User::all(),
            'statuses' => ProjectStatus::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->checkUserAbility('manage projects');

        return view('crm.admin.projects.edit', [
            'project' => $project->loadMissing(['user', 'client', 'status']),
            'clients' => User::role(UserRoles::CLIENT->value)->get(),
            'users' => User::role(UserRoles::USER->value)->get(),
            'statuses' => ProjectStatus::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Project $project)
    {
        $this->checkUserAbility('manage projects');

        try {
            $requestedProjectStatusName = Str::camel(
                ProjectStatus::find($request->get('project_status_id'))->status
            );
            $project->state()->{$requestedProjectStatusName}();
        } catch (StateException $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()
                ->add(
                    'project_status_id',
                    __('Project cannot be moved to :Status', ['status' => $requestedProjectStatusName])
                );
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $project->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')->toMediaCollection(Project::MEDIA_GALLERY_KEY);
        }

        return to_route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->checkUserAbility('manage projects');

        $project->delete();
        return to_route('projects.index');
    }
}
