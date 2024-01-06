<?php

namespace App\Http\Resources\V1;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $estimation
 * @property User $user
 * @property Project $project
 * @property ProjectStatus $status
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'estimation' => $this->estimation,
            'assigned_to' => $this->whenLoaded('user', fn() => $this->user->name),
            'project' => $this->whenLoaded('project', fn() => $this->project->title),
            'status' => $this->whenLoaded('status', fn() => $this->status->status),
        ];
    }
}
