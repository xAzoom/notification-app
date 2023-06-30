<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Query;

use App\Message\Account\Domain\Model\Account;
use App\Message\Message\Application\Query\ViewModel\MessageTransformer;
use App\Message\Message\Domain\Model\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ListDirectsMessagesView implements ListDirectsMessagesQuery
{
    private EntityManagerInterface $em;

    private MessageTransformer $messageTransformer;

    public function __construct(EntityManagerInterface $em, MessageTransformer $messageTransformer)
    {
        $this->em = $em;
        $this->messageTransformer = $messageTransformer;
    }

    public function listDirectMessages(Uuid $firstAccount, Uuid $secondAccount): array
    {
        $accountIdToNameMap = $this->getAccountIdToNameMap($firstAccount, $secondAccount);

        $messages = $this->em->createQueryBuilder()
            ->select('m')
            ->from(Message::class, 'm')
            ->leftJoin('m.recipients', 'r')
            ->setParameter('senderId', $firstAccount, 'uuid')
            ->andWhere('(m.senderId = :senderId AND r.recipientId = :recipientId) OR (m.senderId = :recipientId AND r.recipientId = :senderId)')
            ->setParameter('recipientId', $secondAccount, 'uuid')
            ->orderBy('m.sentAt', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return $this->messageTransformer->transformMultiple($messages, $accountIdToNameMap);
    }

    private function getAccountIdToNameMap(Uuid $senderId, Uuid $recipientId): array
    {
        $map = [(string) $recipientId => 'Nieznany', (string) $senderId => 'Nieznany'];

        $accounts = $this->em->createQueryBuilder()
            ->select('a')
            ->from(Account::class, 'a')
            ->andWhere('a.id IN (:senderId, :recipientId)')
            ->setParameter('senderId', $senderId, 'uuid')
            ->setParameter('recipientId', $recipientId, 'uuid')
            ->getQuery()
            ->getArrayResult();

        foreach ($accounts as $account) {
            $map[(string) $account['id']] = $account['name.name'];
        }

        return $map;
    }
}