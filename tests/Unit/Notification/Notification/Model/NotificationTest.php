<?php
declare(strict_types=1);

namespace App\Tests\Unit\Notification\Notification\Model;

use App\Notification\Notification\Domain\Exception\InvalidRecipientException;
use App\Notification\Notification\Domain\Exception\NotRecipientsDefinedException;
use App\Notification\Notification\Domain\Exception\RecipientsDuplicationException;
use App\Notification\Notification\Domain\Model\Notification;
use App\Tests\Shared\ObjectMother\Notification\NotificationObjectMother;
use App\Tests\Shared\ObjectMother\Notification\SystemNotificationTypeObjectMother;
use App\Tests\Shared\ObjectMother\Notification\TitleObjectMother;
use App\Tests\Shared\TestDouble\Shared\ClockStub;
use App\Tests\Unit\BaseUnitTestCase;
use Symfony\Component\Uid\Uuid;

class NotificationTest extends BaseUnitTestCase
{
    public function testUnsuccessfulCreateWithoutRecipients(): void
    {
         $this->expectException(NotRecipientsDefinedException::class);

         new Notification(Uuid::v4(), TitleObjectMother::validTitle(), [], SystemNotificationTypeObjectMother::random(), new ClockStub());
    }

    public function testUnsuccessfulCreateWithRecipientsDuplication(): void
    {
        $this->expectException(RecipientsDuplicationException::class);

        $id = Uuid::v4();
        new Notification(
            Uuid::v4(),
            TitleObjectMother::validTitle(),
            [$id, Uuid::fromString((string) $id)],
            SystemNotificationTypeObjectMother::random(),
            new ClockStub()
        );
    }

    public function testUnsuccessfulCreateWithInvalidRecipients(): void
    {
        $this->expectException(InvalidRecipientException::class);

        new Notification(
            Uuid::v4(),
            TitleObjectMother::validTitle(),
            [1],
            SystemNotificationTypeObjectMother::random(),
            new ClockStub()
        );
    }

    public function testMakeAsReadNotification(): void
    {
        //given
        $recipientId = Uuid::v4();
        //and
        $notification = NotificationObjectMother::randomWithRecipients([$recipientId]);

        //when
        $notification->makeAsRead($recipientId);

        //then
        $this->assertEquals(true, $notification->getRecipients()[0]->isRead());
    }

    public function testMakeAsUnreadNotification(): void
    {
        //given
        $recipientId = Uuid::v4();
        //and
        $notification = NotificationObjectMother::randomWithRecipients([$recipientId]);
        //and
        $notification->makeAsRead($recipientId);

        //when
        $notification->makeAsUnread($recipientId);

        //then
        $this->assertEquals(false, $notification->getRecipients()[0]->isRead());
    }

    public function testDeleteNotification(): void
    {
        //given
        $recipientId = Uuid::v4();
        //and
        $notification = NotificationObjectMother::randomWithRecipients([$recipientId]);

        //when
        $notification->delete($recipientId);

        //then
        $this->assertEmpty($notification->getRecipients());
    }
}