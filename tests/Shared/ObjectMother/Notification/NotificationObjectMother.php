<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Notification;

use App\Notification\Notification\Domain\Model\Notification;
use App\Tests\Shared\TestDouble\Shared\ClockStub;
use Symfony\Component\Uid\Uuid;

class NotificationObjectMother
{
    public static function random(): Notification
    {
        return new Notification(
            Uuid::v4(),
            TitleObjectMother::validTitle(),
            [Uuid::v4()],
            SystemNotificationTypeObjectMother::random(),
            new ClockStub(),
        );
    }

    public static function randomWithRecipients(array $recipients): Notification
    {
        return new Notification(
            Uuid::v4(),
            TitleObjectMother::validTitle(),
            $recipients,
            SystemNotificationTypeObjectMother::random(),
            new ClockStub(),
        );
    }
}