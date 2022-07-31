<?php

namespace App\service;

use App\Repository\ChatRepository;
use App\Repository\UserRepository;

class MessageService
{
    public function __construct(
        private ChatRepository $chatRepository,
        private UserRepository $userRepository,
    )
    {}

    public function createMessage($token, $secondUserId, $message): bool {
        $sender = $this->userRepository->getByHashKey($token);
        if($sender) {
            return $this->chatRepository->createMessageAndChatIfNeeded($sender->getId(), $secondUserId, $message);
        }
        return false;
    }
}
