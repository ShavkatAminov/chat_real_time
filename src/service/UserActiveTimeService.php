<?php

namespace App\service;



use Predis\Client;

class UserActiveTimeService
{
    const UserActiveKey = "user-active-service";
    public function __construct(private Client $clint) {}

    public function setUserActive(int $id): void {
        $users = json_decode($this->clint->get(self::UserActiveKey), true);
        $users[$id] = time();
        $this->clint->set(self::UserActiveKey, json_encode($users));
    }

    public function getUsersList(): array {
        $array = json_decode($this->clint->get(self::UserActiveKey), true);
        return array_keys(array_filter($array, function ($var) {return $var > (time() - 60 * 5);}));
    }
}
