<?php
declare(strict_types=1);

namespace App\Notification\Account\Infrastructure\Repository;

use App\Notification\Account\Domain\Model\Account;
use App\Notification\Account\Domain\Repository\AccountRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
}