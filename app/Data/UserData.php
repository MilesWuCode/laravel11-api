<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public int $id;

    public CarbonImmutable $created_at;

    public CarbonImmutable $updated_at;

    public function __construct(
        public string $name,
        public string $email,

        /** @var \App\Data\PostData[] */
        public PostData|Optional $post,
    ) {}
}
