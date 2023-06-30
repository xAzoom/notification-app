<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Notification;

use App\Notification\Notification\Domain\Model\Type\SystemNotificationType;

class SystemNotificationTypeObjectMother
{
    public static function random(): SystemNotificationType
    {
        return new SystemNotificationType(null);
    }
}