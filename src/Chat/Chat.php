<?php

namespace App\Chat;
use App\Chat\traits\Auth;
use App\Chat\traits\Message;
use App\service\MessageService;
use App\service\UserActiveTimeService;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    use Auth;
    use Message;
    protected $clients;

    public function __construct(
        private MessageService $messageService,
        private UserActiveTimeService $activeTimeService,
    ) {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        try{
            $request = json_decode($msg, true);
            if($request && isset($request['action']) && $request['action']) {
                call_user_func([$this, $request['action']], $from, $request);
            }
        }
        catch(\Exception $e){
           /* echo 'error try catch';
            print_r($e->getMessage());*/
        }
    }


    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}
