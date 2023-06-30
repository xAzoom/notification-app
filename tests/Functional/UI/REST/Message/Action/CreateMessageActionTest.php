<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Message\Action;

use Symfony\Component\Uid\Uuid;

class CreateMessageActionTest extends AbstractMessageActionTest
{
    public function testCreateMessage(): void
    {
        //given
        $client = self::createClient();
        //and
        $sender = $this->aRandomAccount();
        //and
        $recipient = $this->aRandomAccount();
        //and
        $data = [
            'sender' => (string)$sender->getId(),
            'recipients' => [(string)$recipient->getId()],
            'content' => 'HELLO',
        ];

        //when
        $client->jsonRequest('POST', '/api/messages', $data);
        $response = $client->getResponse();

        //then
        $this->assertEquals(201, $response->getStatusCode());
        //and
        $content = json_decode($response->getContent(), true);
        $message = $this->messageRepository()->findOneById(Uuid::fromString($content['id']));
        $this->assertNotNull($message);
        //and
        $this->assertEquals(1, $this->notificationRepository()->count([]));
    }
}