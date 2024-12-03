<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Carbon\CarbonImmutable;

class PostData extends Data
{
    public function __construct(
      public string $title,
      public string $description,
      public ?CarbonImmutable $published_at
    ) {}
}
