<?php

namespace App\Handler;

use App\Command\CreateTaskCommand;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

final class CreateTaskHandler
{

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function handle(CreateTaskCommand $command): void
    {
        $task = new Task();
        $task->setName($command->name);
        $task->setDescription($command->description);
        $task->setIsDone(false);
        $task->setUser($command->user);

        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
