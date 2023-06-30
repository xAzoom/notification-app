<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Query;

use App\Message\Account\Application\Query\ViewModel\AccountTransformer;
use App\Message\Account\Domain\Model\Account;
use Doctrine\ORM\EntityManagerInterface;

class ListAccountsView implements ListAccountsQuery
{
    private EntityManagerInterface $em;

    private AccountTransformer $accountTransformer;

    public function __construct(
        EntityManagerInterface $em,
        AccountTransformer $accountTransformer
    ) {
        $this->em = $em;
        $this->accountTransformer = $accountTransformer;
    }

    public function listAccounts(): array
    {
        $accounts = $this->em->createQueryBuilder()
            ->select('a')
            ->from(Account::class, 'a')
            ->getQuery()
            ->getArrayResult();

        return $this->accountTransformer->transformMultiple($accounts);
    }
}