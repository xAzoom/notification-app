<?php
declare(strict_types=1);

namespace App\Message\Account\Infrastructure\Repository;

use App\Message\Account\Domain\Model\Account;
use App\Message\Account\Domain\Model\Name;
use App\Message\Account\Domain\Repository\AccountRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class AccountRepository extends ServiceEntityRepository implements AccountRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Account::class);
    }

    public function save(Account $account): void
    {
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->flush();
    }

    public function findOneByName(Name $name): ?Account
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name.name LIKE :name')
            ->setParameter('name', (string)$name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneById(Uuid $id): ?Account
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id, 'uuid')
            ->getQuery()
            ->getOneOrNullResult();
    }
}