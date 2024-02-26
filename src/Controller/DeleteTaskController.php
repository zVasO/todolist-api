<?php

namespace App\Controller;

use App\Command\CreateTaskCommand;
use App\Command\DeleteTaskCommand;
use App\Handler\CreateTaskHandler;
use App\Handler\DeleteTaskHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/task/{id}', name: 'delete_task', methods: ['DELETE'], format: 'json')]
class DeleteTaskController extends AbstractController
{
    public function __construct(
        private DeleteTaskHandler $handler,
    ) {
    }

    public function __invoke(int $id): Response
    {
        $command = new DeleteTaskCommand($id);
        $user = $this->getUser();
        $this->handler->handle($command, $user);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
