<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Repository;

use App\Message\Account\Domain\Model\Account;
use App\Message\Account\Domain\Model\Name;
use Symfony\Component\Uid\Uuid;

interface AccountRepositoryInterface
{
    public function save(Account $account): void;

    public function findOneByName(Name $name): ?Account;

    public function findOneById(Uuid $id): ?Account;
}