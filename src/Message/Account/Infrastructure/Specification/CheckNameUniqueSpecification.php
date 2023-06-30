<?php
declare(strict_types=1);

namespace App\Message\Account\Infrastructure\Specification;

use App\Message\Account\Domain\Model\Name;
use App\Message\Account\Domain\Specification\CheckNameUniqueSpecificationInterface;
use App\Message\Account\Infrastructure\Repository\AccountRepository;

class CheckNameUniqueSpecification implements CheckNameUniqueSpecificationInterface
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function isUniqueName(Name $name): bool
    {
        return null === $this->accountRepository->findOneByName($name);
    }
}