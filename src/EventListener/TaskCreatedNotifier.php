<?php

namespace App\EventListener;

use App\Entity\Task;
use App\Message\TaskCreatedEmailNotification;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;


#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Task::class)]
class TaskCreatedNotifier
{


    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function postPersist(Task $task, PostPersistEventArgs $event): void
    {
        $this->bus->dispatch(new TaskCreatedEmailNotification($task->getName()));
    }
}
