<?php

namespace App\service;



use Predis\Client;

class UserActiveTimeService
{
    const UserActiveKey = "user-active-service";
    public function __construct(private Client $clint)
    {

    }

    public function setUserActive(int $id): void {
        $users = json_decode($this->clint->get(self::UserActiveKey), true);
        $users[$id] = 1;
        $this->clint->set(self::UserActiveKey, json_encode($users));
    }

    public function getUsersList(): array {
        return json_decode($this->clint->get(self::UserActiveKey), true);
    }
}
