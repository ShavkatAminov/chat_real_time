<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Tests\Repository\Basic\BasicKernel;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRepositoryTest extends BasicKernel
{
    protected array $entities = [User::class];

    public function testAddAndRemove() {


        $user = $this->addNewUser();
        $userFind = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'test@mail.com']);

        $this->assertEquals($user, $userFind);
        $this->assertNotNull($user->getCreatedAt());
        $this->assertNotNull($user->getUpdatedAt());
        $this->entityManager->getRepository(User::class)
            ->remove($user, true);

        $userFind = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'test@mail.com']);
        $this->assertNull($userFind);
    }

    public function addNewUser(): User {
        $user = new User();
        $user->setEmail("test@mail.com");
        $user->setHashKey("hashkey");
        $user->setPassword(
            'dcdcdcdc dcdcdcddcdcd'
        );
        $user->setRoles([]);
        $this->entityManager->getRepository(User::class)
            ->add($user, true);
        return $user;
    }


    public function testUpgradePassword() {

        $user = $this->addNewUser();
        $this->entityManager->getRepository(User::class)
            ->upgradePassword($user, "djhsbcjhbjdbhjshbcjshbdjhbsdhc");
        $this->assertEquals($user->getPassword(), 'djhsbcjhbjdbhjshbcjshbdjhbsdhc');

    }

    public function testUpdateHashKey() {
        $user = $this->addNewUser();
        $this->entityManager->getRepository(User::class)
            ->updateHashKey($user);

        $this->assertNotEquals($user->getHashKey(), 'hashkey');
    }

    public function testGetByHashKey() {
        $this->addNewUser();
        $user = $this->entityManager->getRepository(User::class)
            ->getByHashKey('hashkey');
        $userFind = $this->entityManager->getRepository(User::class)->findOneBy(['hashKey' => 'hashkey']);
        $this->assertEquals($user, $userFind);
    }
    public function testFindOthers() {
        $user = $this->addNewUser();
        $users = $this->entityManager->getRepository(User::class)
            ->findOthers($user->getId());
        $userFind = $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.id != :val')
            ->setParameter('val', $user->getId())
            ->getQuery()
            ->getArrayResult();
        $this->assertEquals($users, $userFind);
    }
}
