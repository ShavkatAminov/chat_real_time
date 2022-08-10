<?php

namespace App\Tests\Repository;

use App\Entity\Chat;
use App\Entity\Message;
use App\Tests\Repository\Basic\BasicKernel;

class ChatRepositoryTest extends BasicKernel
{

    protected array $entities = [Chat::class, Message::class];

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

    public function testCreateMessageAndChatIfNeeded() {

        $this->entityManager->getRepository(Chat::class)
            ->createMessageAndChatIfNeeded(1, 2, "testing message");

        $chatFind = $this->entityManager->getRepository(Chat::class)->findOneBy(['first_user' => 1, 'second_user' => 2]);

        $this->assertNotNull($chatFind);
        if($chatFind) {
            $message = $this->entityManager->getRepository(Message::class)->findOneBy(['chat_id' => $chatFind->getId()]);
            $this->assertNotNull($message);
            $this->assertEquals($message->getContent(), 'testing message');
        }

        $this->entityManager->getRepository(Chat::class)
            ->createMessageAndChatIfNeeded(1, 2, "message");

        $chatFind = $this->entityManager->getRepository(Chat::class)->findBy(['first_user' => 1, 'second_user' => 2]);
        $this->assertNotNull($chatFind);
        $this->assertEquals(count($chatFind), 1);
    }
}
