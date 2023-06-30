<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Message\Action;

class EditMessageActionTest extends AbstractMessageActionTest
{
    public function testEditMessage(): void
    {
        //given
        $client = self::createClient();
        //and
        $message = $this->aMessage();
        //and
        $data = ['content' => 'avgfdnj.lkasdnlk'];

        //when
        $client->jsonRequest('PATCH', '/api/messages/' . $message->getId(), $data);
        $response = $client->getResponse();

        //then
        $this->assertEquals(204, $response->getStatusCode());
        //and
        $message = $this->messageRepository()->findOneById($message->getId());
        $this->assertEquals($data['content'], $message->toDTO()->getContent());
    }
}