<?php

namespace App\DataValueObjects\GitHub;

readonly class RepositoryOwnerData
{
    public function __construct(
        public int $id,
        public string $login,
    ) {
    }
}
