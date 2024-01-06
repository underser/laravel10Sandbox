<?php

namespace App\Http\Resources\V1;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $country_code
 * @property string $phone
 * @property string $vat
 * @property string $address
 * @property Collection<Project> $projects
 */
class ClientResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'vat' => $this->vat,
            'address' => $this->address,
            'projects' => ProjectResource::collection($this->projects)
        ];
    }
}
