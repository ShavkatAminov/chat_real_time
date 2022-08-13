<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Tests\Repository\Basic\BasicKernel;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRepositoryTest extends BasicKernel
{
    protected array $entities = [User::class];

    public function testAdd() {
        $user = new User();
        $user->setEmail("test@mail.com");
        $user->setHashKey("hashkey");
        $user->setPassword(
            'dcdcdcdc dcdcdcddcdcd'
        );
        $user->setRoles([]);
        $this->entityManager->getRepository(User::class)
            ->add($user, true);

        $userFind = $this->entityManager->getRepository(User::class)->find($user->getId());

        $this->assertEquals($user, $userFind);
        $this->assertNotNull($user->getCreatedAt());
        $this->assertNotNull($user->getUpdatedAt());
        $this->entityManager->getRepository(User::class)
            ->remove($user, true);

        $userFind = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'test@mail.com']);
        $this->assertNull($userFind);
    }


   /* public function testUpgradePassword() {
        $chat = new Chat();
        $chat->setFirstUser(1);
        $chat->setSecondUser(2);

        $this->entityManager->getRepository(Chat::class)
            ->remove($chat, true);

        $chatFind = $this->entityManager->getRepository(Chat::class)->findOneBy(['first_user' => 1, 'second_user' => 2]);

        $this->assertNull($chatFind);
    }*/
}
