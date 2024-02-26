<?php

namespace App\Command;

use App\Entity\User;

final class CreateTaskCommand
{
    public User $user;

    public function __construct(
        public string $name,
        public string $description,
    ) {
    }
}
