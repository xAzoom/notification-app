<?php
declare(strict_types=1);

namespace App\Tests\Functional\Common;

use App\Message\Account\Domain\Model\Account;
use App\Notification\Account\Domain\Model\Account as NotificationAccount;
use Doctrine\ORM\EntityManagerInterface;

class CommonAccountFactory
{
    public static function create(Account $account, EntityManagerInterface $em): void
    {
        $em->persist($account);
        $em->persist(new NotificationAccount($account->getId()));
        $em->flush();
    }
}