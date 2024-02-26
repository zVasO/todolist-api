<?php

namespace App\Handler;

use App\Command\DeleteTaskCommand;
use App\Command\UpdateTaskCommand;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Auth\Access\AuthorizationException;

final class DeleteTaskHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeleteTaskCommand $command, User $user): void
    {
        $task = $this->entityManager->getRepository(Task::class)->find($command->id);

        if (!$task) {
            throw new \InvalidArgumentException('Task not found.');
        }

        if ($task->getUser() !== $user) {
            throw new AuthorizationException('You are not allowed to do this action !');
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
