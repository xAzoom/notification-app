<?php
declare(strict_types=1);

namespace App\Notification\Notification\Infrastructure\Repository;

use App\Notification\Notification\Domain\Model\Notification;
use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class NotificationRepository extends ServiceEntityRepository implements NotificationRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Notification::class);
    }

    public function save(Notification $notification): void
    {
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
    }

    public function findOneById(Uuid $id): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.id = :id')
            ->setParameter('id', $id, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
    }
}