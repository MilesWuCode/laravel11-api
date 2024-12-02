<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PostData extends Data
{
    public int $id;

    public CarbonImmutable $created_at;

    public CarbonImmutable $updated_at;

    public function __construct(
        #[Max(100)]
        public string $title,
        public string|Optional $description,
        #[Date]
        public ?CarbonImmutable $published_at,

        /** @var \App\Data\UserData[] */
        public UserData|Optional $user,
    ) {}
}
