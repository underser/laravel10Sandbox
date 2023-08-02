<?php

namespace App\Models;

use App\Models\Traits\PaginatorDefaults;
use App\States\Project\ProjectStateInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use PaginatorDefaults;

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
}
