<?php
declare(strict_types=1);

namespace App\States\Project;

use App\Mail\ProjectStatusChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PostponeProjectState extends BaseProjectState
{
    public function inProgress(): void
    {
        Mail::to(User::find($this->project->client->id))
            ->send(
                new ProjectStatusChanged(
                    status: __('In Progress'),
                    url: route('projects.show', $this->project)
                )
            );
    }

    public function closed(): void
    {
        Mail::to(User::find($this->project->client->id))
            ->send(
                new ProjectStatusChanged(
                    status: __('Closed'),
                    url: route('projects.show', $this->project)
                )
            );
    }
}
