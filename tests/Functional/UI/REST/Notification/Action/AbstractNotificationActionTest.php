<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Notification\Action;

use App\Notification\Notification\Domain\Model\Notification;
use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Tests\Functional\BaseFunctionalTestCase;
use App\Tests\Shared\ObjectMother\Notification\NotificationObjectMother;

abstract class AbstractNotificationActionTest extends BaseFunctionalTestCase
{
    public function aNotificationReadWithRecipients(array $recipients): Notification
    {
        $notification = NotificationObjectMother::randomWithRecipients($recipients);
        foreach ($recipients as $recipient) {
            $notification->makeAsRead($recipient);
        }
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
        return $notification;
    }

    protected function aNotificationWithRecipients(array $recipients): Notification
    {
        $notification = NotificationObjectMother::randomWithRecipients($recipients);
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
        return $notification;
    }

    protected function notificationRepository(): NotificationRepositoryInterface
    {
        return $this->getContainer()->get(NotificationRepositoryInterface::class);
    }
}