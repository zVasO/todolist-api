<?php

namespace App\Command;

final readonly class DeleteTaskCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
