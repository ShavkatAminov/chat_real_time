<?php

namespace App\service;



use Predis\Client;

class UserActiveTimeService
{
    public function __construct(private Client $clint)
    {
        $this->clint->set('');
    }
}
