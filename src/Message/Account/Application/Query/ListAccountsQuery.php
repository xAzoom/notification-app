<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Query;

use App\Message\Account\Application\Query\ViewModel\AccountViewModel;

interface ListAccountsQuery
{
    /**
     * @return AccountViewModel[]
     */
    public function listAccounts(): array;
}