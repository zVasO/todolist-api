<?php

namespace App\Controller;

use App\Handler\GetAllTasksHandler;
use App\Query\GetAllTasksQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/tasks', name: 'get_all_tasks', methods: ['GET'], format: 'json')]
final class GetAllTasksController extends AbstractController
{
    public function __construct(
        private GetAllTasksHandler $handler,
        private SerializerInterface $serializer
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $query = new GetAllTasksQuery();
        $tasks = $this->handler->handle($query);

        return new JsonResponse(
            $this->serializer->serialize(
                $tasks,
                'json',
                [AbstractNormalizer::GROUPS => ['task_read']],
            ),
            Response::HTTP_OK,
            [],
            true,
        );
    }
}
