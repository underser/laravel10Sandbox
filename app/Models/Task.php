<?php

namespace App\Models;

use App\Models\Traits\PaginatorDefaults;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    use PaginatorDefaults;

    protected static function booted()
    {
        static::addGlobalScope('onlyActiveTasks', function (Builder $builder) {
            $builder->has('project.client');
        });
        parent::booted();
    }

    protected $guarded = ['id'];

    public function scopeWithAll(Builder $query): void
    {
        $query->with(['project', 'status', 'user']);
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
