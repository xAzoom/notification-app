<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Message\Action;

class DeleteMessageActionTest extends AbstractMessageActionTest
{
    public function testDeleteMessage(): void
    {
        //given
        $client = self::createClient();
        //and
        $message = $this->aMessage();

        //when
        $client->jsonRequest('DELETE', '/api/messages/' . (string) $message->getId());
        $response = $client->getResponse();

        //then
        $this->assertEquals(204, $response->getStatusCode());
        //and
        $message = $this->messageRepository()->findOneById($message->getId());
        $this->assertNull($message);
    }
}