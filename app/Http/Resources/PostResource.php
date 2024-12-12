<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->whenHas('description'),
            'publicshed_at' => $this->whenHas('published_at'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'user' => new UserResource($this->whenLoaded('user')),
            $this->mergeWhen($this->relationLoaded('media'), [
                'cover' => new MediaResource($this->getFirstMedia('cover')),
                'images' => MediaResource::collection($this->getMedia('images')),
            ]),
        ];
    }
}
