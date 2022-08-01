<?php

namespace App\Chat\traits;

use Ratchet\ConnectionInterface;

trait Message
{
    public function message(ConnectionInterface $from, $msg): void
    {
        if ($this->messageService->createMessage($from->token, $msg['user_id'], $msg['content'])) {
            $receiverHash = $this->messageService->getUserHashById($msg['user_id']);
            foreach ($this->clients as $client) {
                if ($client->token == $receiverHash) {
                    $client->send(json_encode([
                        'action' => 'message',
                        'message' => $msg['content'],
                    ]));
                }
            }
        }
    }

    function list(ConnectionInterface $from, $msg): void
    {
        $from->send(json_encode(array_merge(
                ['method' => 'setList'],
                $this->messageService->list($from->token, $msg['user_id'])),
            )
        );
    }
}
