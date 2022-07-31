<?php

namespace App\Chat\traits;

use Ratchet\ConnectionInterface;

trait Auth {
    public function auth(ConnectionInterface $from, $msg): void {
        $from->token = $msg['token'];
    }
}
