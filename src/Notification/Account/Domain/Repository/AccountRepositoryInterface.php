<?php
declare(strict_types=1);

namespace App\Notification\Account\Domain\Repository;

use App\Notification\Account\Domain\Model\Account;

interface AccountRepositoryInterface
{
    public function save(Account  $account): void;
}