<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function add(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Message $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getListByChat($id): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.chat_id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }

    public function getCountMessagesBetween(int $begin, int $end): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.chat_id, count(m.id) as count_of_messages')
            ->where('m.createdAt >= :begin')
            ->andWhere('m.createdAt <= :end')
            ->setParameter('begin', $begin)
            ->setParameter('end', $end)
            ->groupBy('m.chat_id')
            ->getQuery()
            ->getArrayResult();
    }

    public function getLongestMessage(int $begin, int $end): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.content, LENGTH(m.content) as length')
            ->where('m.createdAt >= :begin')
            ->andWhere('m.createdAt <= :end')
            ->setParameter('begin', $begin)
            ->setParameter('end', $end)
            ->orderBy('length', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getArrayResult();
    }

    public function getQueryWithPagination(Request $request): QueryBuilder
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        return $this
            ->createQueryBuilder('a')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit);
    }

    public function getGroupBy(QueryBuilder $builder): QueryBuilder
    {
        return $builder
            ->select('GroupConcat(a.content) as content, DIV(a.createdAt, 60) as timeAsMin')
            ->groupBy('a.chat_id');
    }

    public function getListByRandom(): array
    {
        $max = $this->createQueryBuilder('m')
            ->select('max(m.id) as max')
            ->getQuery()->getScalarResult();
        if (isset($max[0]['max'])) {
            $max = $max[0]['max'];
            $randomIds = [];
            for ($i = 0; $i < 15; $i++) {
                $randomIds [] = rand(1, $max);
            }
            return $this->findBy(['id' => $randomIds]);
        }
        return [];
    }

    public function getSearchQuery(Request $request): QueryBuilder
    {
        $query = $this->getQueryWithPagination($request);
        $query = $this->getGroupBy($query);
        $filters = json_decode($request->get('filter', "[]"), true);
        foreach ($filters as $key => $value) {

            $field = $this->isField($key);

            if ($field) {
                if (empty($value)) {
                    continue;
                }
                $query
                    ->andWhere("a.$field = :$field")
                    ->setParameter($field, $value);
            }
        }
        return $query;
    }

    private function isField($filed)
    {
        $class = $this->_class;

        if (!isset($class->fieldMappings[$filed])) {
            return null;
        }

        return $filed;
    }
}
