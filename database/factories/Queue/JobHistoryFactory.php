<?php

namespace Database\Factories\Queue;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_id' => Str::orderedUuid(),
            'job_id' => Str::orderedUuid(),
            'payload' => serialize([]),
            'errors' => serialize([])
        ];
    }
}
