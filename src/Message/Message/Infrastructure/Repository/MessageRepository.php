<?php
declare(strict_types=1);

namespace App\Message\Message\Infrastructure\Repository;

use App\Message\Message\Domain\Model\Message;
use App\Message\Message\Domain\Repository\MessageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class MessageRepository extends ServiceEntityRepository implements MessageRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Message::class);
    }

    public function save(Message $message): void
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }

    public function findOneById(Uuid $id): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function remove(Message $message): void
    {
        $this->getEntityManager()->remove($message);
        $this->getEntityManager()->flush();
    }
}