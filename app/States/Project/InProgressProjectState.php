<?php
declare(strict_types=1);

namespace App\States\Project;

use App\Mail\ProjectStatusChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class InProgressProjectState extends BaseProjectState
{
    public function postponed(): void
    {
        Mail::to(User::find($this->project->client->id))
            ->send(
                new ProjectStatusChanged(
                    status: __('Postponed'),
                    url: route('projects.show', $this->project)
                )
            );
    }

    public function estimation(): void
    {
        Mail::to(User::find($this->project->client->id))
            ->send(
                new ProjectStatusChanged(
                    status: __('Estimation'),
                    url: route('projects.show', $this->project)
                )
            );
    }

    public function done(): void
    {
        Mail::to(User::find($this->project->client->id))
            ->send(
                new ProjectStatusChanged(
                    status: __('Done'),
                    url: route('projects.show', $this->project)
                )
            );
    }
}
