<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Projects\Store;
use App\Http\Requests\Api\V1\Projects\Update;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Response;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjectResource::collection(Project::withAll()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        /** @var Project $project */
        $project = Project::factory()->create($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')->toMediaCollection(Project::MEDIA_GALLERY_KEY);
        }

        return new ProjectResource($project->loadMissing(['user', 'client', 'tasks', 'status']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return new ProjectResource($project->loadMissing(['user', 'client', 'tasks', 'status']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Project $project)
    {
        $project->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $project->addMediaFromRequest('image')->toMediaCollection(Project::MEDIA_GALLERY_KEY);
        }

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->checkUserAbility('manage projects');

        $project->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
