<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Post
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            $this->attributes(['id', 'title']),
            'description' => $this->whenHas('description'),
            'publicshed_at' => $this->whenHas('published_at'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'user' => new UserResource($this->whenLoaded('user')),
            // * scramble需要用這個
            $this->mergeWhen($this->relationLoaded('media'), [
                'cover' => new MediaResource($this->getFirstMedia('cover')),
                'images' => MediaResource::collection($this->getMedia('images')),
            ]),
        ];
    }
}
