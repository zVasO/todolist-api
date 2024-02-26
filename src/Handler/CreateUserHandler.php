<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateUserHandler
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function handle(CreateUserCommand $command): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $command->email]);
        if ($user !== null) {
            throw new RuntimeException('A user already exists for this email', Response::HTTP_FORBIDDEN);
        }

        $user = new User();
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->password);
        $user->setEmail($command->email)
            ->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
