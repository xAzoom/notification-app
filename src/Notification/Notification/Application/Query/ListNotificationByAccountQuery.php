<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Query;

use Symfony\Component\Uid\Uuid;

interface ListNotificationByAccountQuery
{
    public function listNotificationByAccount(Uuid $accountId): array;
}