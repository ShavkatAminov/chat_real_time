<?php

namespace App\Repository;

use App\Entity\Chat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Message;

/**
 * @extends ServiceEntityRepository<Chat>
 *
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function add(Chat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function createMessageAndChatIfNeeded(int $firstUserId, int $secondUserId, string $content): bool
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();
        try {
            $chat = $this->findOneBy(['first_user' => [$firstUserId, $secondUserId], 'second_user' => [$firstUserId, $secondUserId]]);

            if (!$chat) {
                $chat = new Chat();
                $chat->setFirstUser($firstUserId);
                $chat->setSecondUser($secondUserId);
                $em->persist($chat);
                $em->flush();
            }

            $message = new Message();
            $message->setChatId($chat->getId());
            $message->setContent($content);
            $message->setSenderIsFirst($firstUserId == $chat->getFirstUser());
            $em->persist($message);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            return false;
        }
        return true;
    }

}
