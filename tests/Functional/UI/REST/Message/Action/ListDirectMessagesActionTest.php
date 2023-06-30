<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Message\Action;

class ListDirectMessagesActionTest extends AbstractMessageActionTest
{
    public function testListDirectMessages(): void
    {
        //given
        $client = self::createClient();
        //and
        $firstAccount = $this->aRandomAccount();
        //and
        $secondAccount = $this->aRandomAccount();
        //and
        $this->aMessageWithSenderAndRecipients($firstAccount->getId(), [$secondAccount->getId()]);
        //and
        $this->aMessageWithSenderAndRecipients($firstAccount->getId(), [$secondAccount->getId()]);
        //and
        $this->aMessageWithSenderAndRecipients($secondAccount->getId(), [$firstAccount->getId()]);
        //and
        $this->aMessageWithSenderAndRecipients($firstAccount->getId(), [$secondAccount->getId()]);

        //when
        $client->request('GET', '/api/messages', [
            'firstAccount' => (string)$firstAccount->getId(),
            'secondAccount' => (string)$secondAccount->getId()
        ]);
        $response = $client->getResponse();

        //then
        $this->assertEquals(200, $response->getStatusCode());
        //and
        $content = json_decode($response->getContent(), true);
        $this->assertCount(4, $content);
    }
}