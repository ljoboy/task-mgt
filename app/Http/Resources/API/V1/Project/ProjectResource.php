<?php

declare(strict_types=1);

namespace App\Http\Resources\API\V1\Project;

use App\Http\Resources\API\V1\Task\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks'))

        ];
    }
}
