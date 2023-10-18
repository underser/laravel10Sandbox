<?php

namespace App\Models;

use App\Models\Traits\PaginatorDefaults;
use App\States\Project\ProjectStateInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use JeroenG\Explorer\Application\Aliased;
use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia, Explored, Aliased
{
    use HasFactory, InteractsWithMedia, PaginatorDefaults, Searchable;

    public const MEDIA_GALLERY_KEY = 'project-images-main';

    protected $guarded = ['id'];

    protected $attributes = [
        'project_status_id' => 1 // New project always Open.
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    public function scopeWithAll(Builder $query): void
    {
        $query->with(['user', 'client', 'tasks', 'status']);
    }

    public function state(): ProjectStateInterface
    {
        $class = '\\App\\States\\Project\\' . Str::studly($this->status->status) . 'ProjectState';
        if (class_exists($class)) {
            return new $class($this);
        }

        throw new InvalidArgumentException('Invalid status.');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function makeSearchableUsing(BaseCollection $models): BaseCollection
    {
        return $models->load(['user', 'client', 'status']);
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'title' => 'text',
            'description' => 'text',
            'status' => 'text',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status->status,
            'user' => $this->user->id,
            'client' => $this->client->id,
        ];
    }
}
