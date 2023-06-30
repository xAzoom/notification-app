<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Account;

use App\Message\Account\Domain\Repository\AccountRepositoryInterface;
use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\Uid\Uuid;

class CreateAccountActionTest extends BaseFunctionalTestCase
{
    public function testCreate(): void
    {
        //given
        $client = self::createClient();
        //and
        $data = ['name' => 'test'];

        //when
        $client->jsonRequest('POST', '/api/accounts', $data);
        $response = $client->getResponse();

        //then
        $this->assertEquals(201, $response->getStatusCode());
        //and
        $content = json_decode($response->getContent(), true);
        $account = $this->accountRepository()->findOneById(Uuid::fromString($content['id']));
        $this->assertNotNull($account);
        //and
        $this->assertEquals($data['name'], (string)$account->getName());
    }

    protected function accountRepository(): AccountRepositoryInterface
    {
        return $this->getContainer()->get(AccountRepositoryInterface::class);
    }
}