<?php

namespace App\Tests\Repository;

use App\Entity\Chat;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Repository\Basic\BasicKernel;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends BasicKernel
{
    protected array $entities = [User::class];

    public function testAdd() {
        $chat = new Chat();
        $chat->setFirstUser(1);
        $chat->setSecondUser(2);

        $this->entityManager->getRepository(Chat::class)
            ->add($chat, true);

        $chatFind = $this->entityManager->getRepository(Chat::class)->findOneBy(['first_user' => 1, 'second_user' => 2]);

        $this->assertEquals($chat, $chatFind);
        $this->assertNotNull($chat->getCreatedAt());
        $this->assertNotNull($chat->getUpdatedAt());
    }


    public function testRemove() {
        $chat = new Chat();
        $chat->setFirstUser(1);
        $chat->setSecondUser(2);

        $this->entityManager->getRepository(Chat::class)
            ->remove($chat, true);

        $chatFind = $this->entityManager->getRepository(Chat::class)->findOneBy(['first_user' => 1, 'second_user' => 2]);

        $this->assertNull($chatFind);
    }
}
