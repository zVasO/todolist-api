<?php

namespace App\Command;

use App\Entity\User;

final readonly class CreateTaskCommand
{
    public function __construct(
        public string $name,
        public string $description,
        public User $user
    ) {
    }
}
