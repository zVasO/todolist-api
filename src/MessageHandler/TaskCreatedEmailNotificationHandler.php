<?php

namespace App\MessageHandler;

use App\Message\TaskCreatedEmailNotification;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class TaskCreatedEmailNotificationHandler
{
    public function __construct(
        private MailerInterface $mailer,
        private UserRepository $userRepository
    )
    {
    }

    public function __invoke(TaskCreatedEmailNotification $message): void
    {
        $users = $this->userRepository->findAll();
        foreach ($users as $user) {
            $this->sendEmailToUser($user->getEmail(), $message->getTaskName());
        }
    }

    private function sendEmailToUser(string $userEmail, string $taskName): void
    {
        $email = (new Email())
            ->from('todo@testing.io')
            ->to($userEmail)
            ->subject('Nouvelle tâche créée')
            ->html('<p>Une nouvelle tâche a été créée : '. $taskName .'</p>');

        $this->mailer->send($email);
    }
}
