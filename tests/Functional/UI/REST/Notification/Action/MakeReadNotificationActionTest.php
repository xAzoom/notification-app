<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Notification\Action;

use Symfony\Component\Uid\Uuid;

class MakeReadNotificationActionTest extends AbstractNotificationActionTest
{
    public function testMakeRead(): void
    {
        //given
        $client = self::createClient();
        //and
        $recipientId = Uuid::v4();
        //and
        $notification = $this->aNotificationWithRecipients([$recipientId]);
        //and
        $data = ['recipientId' => (string) $recipientId];

        //when
        $client->jsonRequest('POST', '/api/notifications/' . $notification->getId() . '/read', $data);
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
        $this->assertTrue($recipients[0]->isRead());
    }
}