<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            /** @example 1 */
            'id' => $this->id,
            /** @example John Doe */
            'name' => $this->name,
            /** @example johndoe@email.com */
            'email' => $this->email,
        ];
    }
}
