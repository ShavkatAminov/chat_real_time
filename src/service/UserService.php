<?php

namespace App\service;

use App\Repository\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    public function getOtherUserList(int $id): array
    {
        return $this->userRepository->findOthers($id);
    }
}
