<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Query;

use App\Notification\Notification\Application\Query\ViewModel\Transformer\NotificationTransformer;
use App\Notification\Notification\Domain\Model\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ListNotificationByAccountView implements ListNotificationByAccountQuery
{
    private EntityManagerInterface $em;
    private NotificationTransformer $notificationTransformer;

    public function __construct(EntityManagerInterface $em, NotificationTransformer $notificationTransformer)
    {
        $this->em = $em;
        $this->notificationTransformer = $notificationTransformer;
    }

    public function listNotificationByAccount(Uuid $accountId): array
    {
        $result = $this->em->createQueryBuilder()
            ->select('n', 'r')
            ->from(Notification::class, 'n')
            ->innerJoin('n.recipients', 'r', 'WITH', 'r.recipientId = :accountId')
            ->setParameter('accountId', $accountId, 'uuid')
            ->orderBy('n.sentAt', 'DESC')
            ->getQuery()
            ->getArrayResult();

        return $this->notificationTransformer->transformMultiple($result);
    }
}