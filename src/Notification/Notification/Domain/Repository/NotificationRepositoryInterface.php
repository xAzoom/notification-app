<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Repository;

use App\Notification\Notification\Domain\Model\Notification;
use Symfony\Component\Uid\Uuid;

interface NotificationRepositoryInterface
{
    public function save(Notification $notification): void;

    public function findOneById(Uuid $id): ?Notification;
}