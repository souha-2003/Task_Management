<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'note' => $this->note,
            'status' => $this->status,
            'is_completed' => $this->completed,
            'completed_at' => $this->completed_at ? $this->completed_at->format('Y-m-d H:i') : null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i') : null,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
