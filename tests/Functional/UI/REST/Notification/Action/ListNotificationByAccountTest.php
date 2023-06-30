<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Notification\Action;

use Symfony\Component\Uid\Uuid;

class ListNotificationByAccountTest extends AbstractNotificationActionTest
{
    public function testListNotificationByAccountTest(): void
    {
        //given
        $client = self::createClient();
        //and
        $firstRecipientId = Uuid::v4();
        //and
        $secondRecipientId = Uuid::v4();
        //and
        $this->aNotificationWithRecipients([$firstRecipientId]);
        //and
        $this->aNotificationWithRecipients([$firstRecipientId]);
        //and
        $this->aNotificationWithRecipients([$firstRecipientId, $secondRecipientId]);
        //and
        $this->aNotificationWithRecipients([$secondRecipientId]);

        //when
        $client->request('GET', '/api/notifications', ['accountId' => (string)$firstRecipientId]);
        $response = $client->getResponse();

        //then
        $this->assertEquals(200, $response->getStatusCode());
        //and
        $content = json_decode($response->getContent(), true);
        $this->assertCount(3, $content);
    }
}