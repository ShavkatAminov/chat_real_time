<?php
namespace App\Chat\traits;

use Ratchet\ConnectionInterface;

trait Message {
    public function message(ConnectionInterface $from, $msg): void {
        if($this->messageService->createMessage($from->token, $msg['user_id'], $msg['content'])) {

        }
    }
}
