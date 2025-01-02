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
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $mergedData = $this->mergeWhen($this->relationLoaded('media'), [
            'cover' => new MediaResource($this->getFirstMedia('cover')),
            'images' => MediaResource::collection($this->getMedia('images')),
        ]);

        return [
            $this->attributes(['id', 'title']),
            'description' => $this->whenHas('description'),
            'publicshed_at' => $this->whenHas('published_at'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'user' => new UserResource($this->whenLoaded('user')),
            // * phpstan報錯
            // $this->mergeWhen($this->relationLoaded('media'), [
            //     'cover' => new MediaResource($this->getFirstMedia('cover')),
            //     'images' => MediaResource::collection($this->getMedia('images')),
            // ]),
            // * 所以使用這個
            ...(is_array($mergedData) ? [
                'cover' => $mergedData['cover'] ?? null,
                'images' => $mergedData['images'] ?? null,
            ] : []),
        ];
    }
}
