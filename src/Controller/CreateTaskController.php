<?php

namespace App\Controller;

use App\Command\CreateTaskCommand;
use App\Handler\CreateTaskHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/task', name: 'create_task', methods: ['POST'], format: 'json')]
class CreateTaskController extends AbstractController
{
    public function __construct(
        private CreateTaskHandler $handler,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateTaskCommand $command): Response
    {
        $user = $this->getUser();
        $command->user = $user;
        $this->handler->handle($command);
        
        return new Response(status: Response::HTTP_CREATED);
    }
}
