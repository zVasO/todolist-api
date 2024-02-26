<?php

namespace App\Controller;

use App\Command\CreateUserCommand;
use App\Handler\CreateUserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/registration', name: 'create_user', methods: ['POST'], format: 'json')]
class CreateUserController extends AbstractController
{
    public function __construct(
        private CreateUserHandler $handler,
    )
    {
    }

    public function __invoke(#[MapRequestPayload] CreateUserCommand $command): Response
    {
        $this->handler->handle($command);

        return new Response(status: Response::HTTP_CREATED);
    }
}
