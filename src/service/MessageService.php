<?php

namespace App\service;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;

class MessageService
{
    public function __construct(
        private ChatRepository $chatRepository,
        private UserRepository $userRepository,
        private MessageRepository $messageRepository,
    )
    {}

    public function createMessage($senderId, $secondUserId, $message): bool {
        return $this->chatRepository->createMessageAndChatIfNeeded($senderId, $secondUserId, $message);
    }

    public function getUserHashById(int $id): string {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        if($user)
            return $user->getHashKey();
        return "";
    }

    public function getUserByHash(string $token): User | null {
        return $this->userRepository->getByHashKey($token);
    }

    public function list($senderId, $secondUserId): array {
        $chat = $this->chatRepository->findOneBy(['first_user' => [$senderId, $secondUserId], 'second_user' => [$senderId, $secondUserId]]);
        if(!$chat)
            return ['message' => [], 'isSenderIsFirst' => false];
        return [
            'messages' => $this->messageRepository->getListByChat($chat->getId()),
            'isSenderIsFirst' => $senderId == $chat->getFirstUser(),
        ];
    }
}
