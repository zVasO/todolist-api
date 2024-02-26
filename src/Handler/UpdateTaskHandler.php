<?php

namespace App\Handler;

use App\Command\UpdateTaskCommand;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final readonly class UpdateTaskHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function handle(UpdateTaskCommand $command, User $user): void
    {
        $task = $this->entityManager->getRepository(Task::class)->find($command->id);

        if (!$task) {
            throw new InvalidArgumentException('Task not found.');
        }

        if ($task->getUser() !== $user) {
            throw new RuntimeException('You are not allowed to do this action !', Response::HTTP_FORBIDDEN);
        }

        if (null !== $command->name) {
            $task->setTitle($command->name);
        }

        if (null !== $command->description) {
            $task->setDescription($command->description);
        }

        if (null !== $command->isDone) {
            $task->setIsDone($command->isDone);
        }

        $this->entityManager->flush();
    }
}
