<?php

namespace App\Controller;

use App\Command\CreateTaskCommand;
use App\Command\DeleteTaskCommand;
use App\Command\UpdateTaskCommand;
use App\Handler\CreateTaskHandler;
use App\Handler\DeleteTaskHandler;
use App\Handler\UpdateTaskHandler;
use App\Http\UpdateTaskRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/task/{id}', name: 'update', methods: ['PUT'], format: 'json')]
class UpdateTaskController extends AbstractController
{
    public function __construct(
        private UpdateTaskHandler $handler,
    ) {
    }

    public function __invoke(int $id, #[MapRequestPayload] UpdateTaskRequest $request): Response
    {
        $user = $this->getUser();
        $this->handler->handle(
            new UpdateTaskCommand(
                $id,
                $request->name,
                $request->description,
                $request->isDone,
            ),
            $user
        );

        return new Response(status: Response::HTTP_OK);
    }
}
