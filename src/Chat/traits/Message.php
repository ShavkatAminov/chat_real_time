<?php

namespace App\Chat\traits;

use Ratchet\ConnectionInterface;

trait Message
{
    public function message(ConnectionInterface $from, $msg): void
    {
        $user = $this->messageService->getUserByHash($from->token);
        if ($user && $this->messageService->createMessage($user->getId(), $msg['user_id'], $msg['content'])) {
            $receiverHash = $this->messageService->getUserHashById($msg['user_id']);
            foreach ($this->clients as $client) {
                if ($client->token == $receiverHash) {
                    $client->send(json_encode([
                        'method' => 'message',
                        'data' => [
                            'content' => $msg['content'],
                            'user_id' => $user->getId(),
                            'isSent' => false,
                        ]
                    ]));
                }
            }
            $from->send(json_encode([
                'method' => 'message',
                'data' => [
                    'content' => $msg['content'],
                    'user_id' => $msg['user_id'],
                    'isSent' => true,
                ]
            ]));
        }
    }

    function list(ConnectionInterface $from, $msg): void
    {
        $user = $this->messageService->getUserByHash($from->token);
        if($user) {
            $from->send(json_encode([
                    'method' => 'setList',
                    'data' => $this->messageService->list($user->getId(), $msg['user_id']),
                ])
            );
        }
    }
}
