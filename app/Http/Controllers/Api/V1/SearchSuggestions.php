<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProjectResource;
use App\Http\Resources\V1\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchSuggestions extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $request->whenFilled('term', function (string $term) {
            return [
                'projects' => ProjectResource::collection(
                    Project::search($term)
                        ->query(
                            fn(Builder $query) =>
                                $query->limit(5)->withCount('tasks')->with(['user', 'client', 'status'])
                        )
                        ->get()
                ),
                'tasks' => TaskResource::collection(
                    Task::search($term)
                        ->query(
                            fn(Builder $query) =>
                                $query->limit(5)->withAll())
                        ->get()
                )
            ];
        }, function () {
            return response([], 404);
        });
    }
}
