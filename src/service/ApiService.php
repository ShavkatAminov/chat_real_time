<?php

namespace App\service;

use App\Repository\MessageRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class ApiService
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    public function getCountByDay(string $date): array {
        $begin = strtotime($date);
        $end = strtotime($date) + 24 * 3600;
        return $this->messageRepository->getCountMessagesBetween($begin, $end);
    }

    public function getLongestMessage(string $date): array {
        $begin = strtotime($date);
        $end = strtotime($date) + 24 * 3600;
        return $this->messageRepository->getLongestMessage($begin, $end);
    }

    public function getRandomRows(): array {
        return $this->messageRepository->getListByRandom();
    }

    public function getList(Request $request): QueryBuilder {
        return $this->messageRepository->getSearchQuery($request);
    }

}
