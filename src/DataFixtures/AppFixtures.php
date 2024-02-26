<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->createUser('test@testing.io', 'password');
        $manager->persist($user);

        $taskNotDone = $this->createTask('Task Not Done', $user, false, 'what a description');
        $manager->persist($taskNotDone);

        $taskDone = $this->createTask('Task Done', $user, true, 'the description');
        $manager->persist($taskDone);

        $manager->flush();
    }

    /**
     * Create a User
     * @param string $email
     * @param string $plainPassword
     * @return User
     */
    private function createUser(string $email, string $plainPassword): User
    {
        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);
        return $user;
    }

    /**
     * @param string $name
     * @param User $user
     * @param bool $isDone
     * @param string $description
     * @return Task
     */
    private function createTask(string $name, User $user, bool $isDone, string $description): Task
    {
        $task = new Task();
        $task->setName($name)
            ->setUser($user)
            ->setIsDone($isDone)
            ->setDescription($description);

        return $task;
    }
}
