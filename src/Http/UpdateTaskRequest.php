<?php

namespace App\Http;

final readonly class UpdateTaskRequest
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?bool $isDone
    ) {
    }
}
