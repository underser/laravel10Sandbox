<?php

namespace App\Models;

use App\Models\Traits\PaginatorDefaults;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory;
    use PaginatorDefaults;
    use InteractsWithMedia;

    public const MEDIA_GALLERY_KEY = 'task-images-main';

    protected $guarded = ['id'];


    protected static function booted()
    {
        static::addGlobalScope('onlyActiveTasks', function (Builder $builder) {
            $builder->has('project.client');
        });
        parent::booted();
    }

    public function scopeWithAll(Builder $query): void
    {
        $query->with(['project', 'status', 'user']);
    }

    protected function estimation(): Attribute
    {
        return new Attribute(
            get: fn(string $value) => $value . 'h',
            set: fn(string $value) => str_replace('h', '', $value)
        );
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
