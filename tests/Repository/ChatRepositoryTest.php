<?php

namespace App\Tests\Repository;

use App\Entity\Chat;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChatRepositoryTest extends KernelTestCase
{

    private EntityManager | null $entityManager = null;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAdd() {
        $chat = new Chat();
        $chat->setFirstUser(1);
        $chat->setSecondUser(2);

        $this->entityManager->getRepository(Chat::class)
            ->add($chat, true);

        $chatFind = $this->entityManager->getRepository(Chat::class)->findOneBy(['first_user' => 1, 'second_user' => 2]);

        $this->assertEquals($chat, $chatFind);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
