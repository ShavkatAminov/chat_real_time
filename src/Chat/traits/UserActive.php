<?php
namespace App\Chat\traits;

use Ratchet\ConnectionInterface;

trait UserActive {

    public function activeList(ConnectionInterface $from, $msg): void {
        $user = $this->messageService->getUserByHash($from->token);
        if($user) {
            $from->send(json_encode([
                'method' => 'setOnlineList',
                'data' => $this->activeTimeService->getUsersList(),
            ]));
        }
    }
}
