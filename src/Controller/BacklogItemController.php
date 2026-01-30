<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class BacklogItemController extends AbstractController
{
    #[Route('/api/backlog-items', name: 'app_backlog_items', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $items = [
                [
                    'id' => 1,
                    'type' => 'movie',
                    'externalId' => 123,
                    'title' => 'Matrix',
                    'status' => 'completed',
                    'progress' => null
                ],
                [
                    'id' => 2,
                    'type' => 'series',
                    'externalId' => 456,
                    'title' => 'Breaking Bad',
                    'status' => 'in_progress',
                    'progress' => 3
                ]
            ];
        return new JsonResponse($items);
    }
}
