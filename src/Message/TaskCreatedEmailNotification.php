<?php

namespace App\Message;

class TaskCreatedEmailNotification
{
    public function __construct(
        private string $taskName,
    ) {
    }

    public function getTaskName(): string
    {
        return $this->taskName;
    }
}
