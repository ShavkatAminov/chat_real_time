<?php

namespace App\Tests\Repository\Basic;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BasicKernel extends KernelTestCase
{

    protected array $entities = [];
    protected EntityManager | null $entityManager = null;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

    }

    protected function tearDown(): void
    {
        foreach ($this->entities as $entity) {
            $this->entityManager->getRepository($entity)
                ->createQueryBuilder('c')
                ->delete()
                ->getQuery()
                ->execute();
        }
        parent::tearDown();
        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
