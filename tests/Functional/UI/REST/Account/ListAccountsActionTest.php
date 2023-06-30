<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Account;

use App\Message\Account\Domain\Model\Account;
use App\Tests\Functional\BaseFunctionalTestCase;
use App\Tests\Functional\Common\CommonAccountFactory;
use App\Tests\Shared\ObjectMother\Message\Account\AccountObjectMother;

class ListAccountsActionTest extends BaseFunctionalTestCase
{
    public function testListAccounts(): void
    {
        //given
        $client = self::createClient();
        //and
        $this->aRandomAccount();
        //and
        $this->aRandomAccount();
        //and
        $this->aRandomAccount();

        //when
        $client->request('GET', '/api/accounts');
        $response = $client->getResponse();

        //then
        $this->assertEquals(200, $response->getStatusCode());
        //and
        $content = json_decode($response->getContent(), true);
        $this->assertCount(3, $content);
    }

    protected function aRandomAccount(): Account
    {
        $account = AccountObjectMother::random();
        CommonAccountFactory::create($account, $this->getEntityManager());
        return $account;
    }
}