<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Notification\Action;

use Symfony\Component\Uid\Uuid;

class MakeUnreadNotificationActionTest extends AbstractNotificationActionTest
{
    public function testMakeUnread(): void
    {
        //given
        $client = self::createClient();
        //and
        $recipientId = Uuid::v4();
        //and
        $notification = $this->aNotificationReadWithRecipients([$recipientId]);
        //and
        $data = ['recipientId' => (string)$recipientId];

        //when
        $client->jsonRequest('POST', '/api/notifications/' . $notification->getId() . '/unread', $data);
        $response = $client->getResponse();

        //then
        $this->assertEquals(204, $response->getStatusCode());
        //and
        $notification = $this->notificationRepository()->findOneById($notification->getId());
        $this->assertNotNull($notification);
        //and
        $recipients = $notification->getRecipients();
        $this->assertCount(1, $recipients);
        //and
        $this->assertFalse($recipients[0]->isRead());
    }
}