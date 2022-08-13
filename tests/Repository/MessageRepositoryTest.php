<?php

namespace App\Tests\Repository;

use App\Entity\Chat;
use App\Entity\Message;
use App\Tests\Repository\Basic\BasicKernel;

class MessageRepositoryTest extends BasicKernel
{
    protected array $entities = [Message::class];

    public function testAdd()
    {
        $message = new Message();
        $message->setChatId(1);
        $message->setContent("message");
        $message->setSenderIsFirst(1);

        $this->entityManager->getRepository(Message::class)
            ->add($message, true);

        $messageFind = $this->entityManager->getRepository(Message::class)->findOneBy(['chat_id' => 1, 'content' => 'message']);

        $this->assertEquals($message, $messageFind);
        $this->assertNotNull($message->getCreatedAt());
        $this->assertNotNull($message->getUpdatedAt());
        $this->entityManager->getRepository(Message::class)
            ->remove($message, true);

        $messageFind = $this->entityManager->getRepository(Message::class)->findOneBy(['chat_id' => 1, 'content' => 'message']);
        $this->assertNull($messageFind);
    }
}
