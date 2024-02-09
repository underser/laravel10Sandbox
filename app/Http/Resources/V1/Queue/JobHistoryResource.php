<?php

namespace App\Http\Resources\V1\Queue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $batch_id
 * @property string $job_id
 * @property string $payload
 * @property string $errors
 */
class JobHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'payload' => unserialize($this->payload, ['allowed_classes' => false]),
            'errors' => unserialize($this->errors, ['allowed_classes' => false]),
        ];
    }
}
