<?php

namespace App\service;

use App\Entity\Message;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

class MessageService
{
    public function __construct(
        private ChatRepository $chatRepository,
        private UserRepository $userRepository,
        private MessageRepository $messageRepository,
    )
    {}

    public function createMessage($token, $secondUserId, $message): bool {
        $sender = $this->userRepository->getByHashKey($token);
        if($sender) {
            return $this->chatRepository->createMessageAndChatIfNeeded($sender->getId(), $secondUserId, $message);
        }
        return false;
    }

    public function getUserHashById(int $id): string {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if($user)
            return $user->getHashKey();
        return "";
    }

    public function list($token, $secondUserId): array {
        $sender = $this->userRepository->getByHashKey($token);
        $chat = $this->chatRepository->findOneBy(['first_user' => [$sender->getId(), $secondUserId], 'second_user' => [$sender->getId(), $secondUserId]]);
        if(!$chat)
            return [];
        return [
            'messages' => $this->messageRepository->getListByChat($chat->getId()),
            'isSenderIsFirst' => $sender->getRoles() == $chat->getFirstUser(),
        ];
    }
}
