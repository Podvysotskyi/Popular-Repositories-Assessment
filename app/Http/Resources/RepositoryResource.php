<?php

namespace App\Http\Resources;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Repository
 */
class RepositoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(?Request $request = null): array
    {
        return [
            'id' => $this->id,
            'name' => "{$this->owner->login}/$this->name",
            'stars' => $this->stars_count,
            'url' => $this->url,
            'description' => $this->description,
            'owner' => $this->owner->login,
            'created_at' => $this->repository_created_at->format('Y-m-d H:i:s'),
            'pushed_at' => $this->repository_pushed_at->format('Y-m-d H:i:s'),
        ];
    }
}
