<?php

namespace App\Controller;

use App\service\ApiService;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    public function __construct(private ApiService $apiService){
    }

    #[Route('/api/message-count/{date}', name: 'app_api_message_count')]
    public function messageCount(string $date): JsonResponse
    {
        return $this->json($this->apiService->getCountByDay($date));
    }

    #[Route('/api/message-random/', name: 'app_api_message_random')]
    public function randomMessages(): JsonResponse
    {
        return $this->json($this->apiService->getRandomRows());
    }

    #[Route('/api/message-longest/{date}', name: 'app_api_message_longest')]
    public function messageLongest(string $date): JsonResponse
    {
        return $this->json($this->apiService->getLongestMessage($date));
    }

    #[Route('/api/message-list/', name: 'app_api_message_list')]
    public function messageList(Request $request): JsonResponse
    {
        return $this->json($this->listDataResponse($this->apiService->getList($request)));
    }

    private function listDataResponse(QueryBuilder $query): array {
        return [
            'total' => count(new Paginator($query)),
            'data' => $query->getQuery()->execute(),
        ];
    }

}
