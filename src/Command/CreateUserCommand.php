<?php

namespace App\Command;

final class CreateUserCommand
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
