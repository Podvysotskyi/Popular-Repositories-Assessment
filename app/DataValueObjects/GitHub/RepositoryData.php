<?php

namespace App\DataValueObjects\GitHub;

use Carbon\Carbon;

readonly class RepositoryData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public Carbon $created_at,
        public Carbon $pushed_at,
        public ?string $description,
        public int $stargazers_count,
        public RepositoryOwnerData $owner,
    ) {}
}
