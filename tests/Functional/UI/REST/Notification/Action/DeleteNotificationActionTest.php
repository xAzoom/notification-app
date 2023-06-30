<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Notification\Action;

use Symfony\Component\Uid\Uuid;

class DeleteNotificationActionTest extends AbstractNotificationActionTest
{
    public function testDelete(): void
    {
        //given
        $client = self::createClient();
        //and
        $recipientId = Uuid::v4();
        //and
        $notification = $this->aNotificationWithRecipients([$recipientId]);
        //and
        $data = ['recipientId' => (string)$recipientId];

        //when
        $client->jsonRequest('DELETE', '/api/notifications/' . $notification->getId(), $data);
        $response = $client->getResponse();

        //then
        $this->assertEquals(204, $response->getStatusCode());
        //and
        $notification = $this->notificationRepository()->findOneById($notification->getId());
        $this->assertNotNull($notification);
        //and
        $this->assertCount(0, $notification->getRecipients());
    }

    public function testDeleteFromMultiRecipients(): void
    {
        //given
        $client = self::createClient();
        //and
        $recipientId = Uuid::v4();
        //and
        $secondRecipientId = Uuid::v4();
        //and
        $notification = $this->aNotificationWithRecipients([$recipientId, $secondRecipientId]);
        //and
        $data = ['recipientId' => (string)$recipientId];

        //when
        $client->jsonRequest('DELETE', '/api/notifications/' . $notification->getId(), $data);
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
        $this->assertEquals($secondRecipientId, $recipients[0]->getRecipientId());
    }
}