<?php

namespace App\Command;

final readonly class UpdateTaskCommand
{
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $description,
        public ?bool $isDone,
    ) {
    }
}
