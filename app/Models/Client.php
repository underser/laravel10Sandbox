<?php

namespace App\Models;

use App\Models\Traits\PaginatorDefaults;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    use PaginatorDefaults;

    protected $guarded = ['id'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
