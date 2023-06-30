<?php
declare(strict_types=1);

namespace App\Tests\Functional\UI\REST\Message\Action;

use App\Message\Account\Domain\Model\Account;
use App\Message\Message\Domain\Model\Message;
use App\Message\Message\Domain\Repository\MessageRepositoryInterface;
use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Tests\Functional\BaseFunctionalTestCase;
use App\Tests\Functional\Common\CommonAccountFactory;
use App\Tests\Shared\ObjectMother\Message\Account\AccountObjectMother;
use App\Tests\Shared\ObjectMother\Message\Message\MessageObjectMother;
use Symfony\Component\Uid\Uuid;

abstract class AbstractMessageActionTest extends BaseFunctionalTestCase
{
    protected function aRandomAccount(): Account
    {
        $account = AccountObjectMother::random();
        CommonAccountFactory::create($account, $this->getEntityManager());
        return $account;
    }

    protected function aMessage(): Message
    {
        $message = MessageObjectMother::random();
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
        return $message;
    }

    protected function aMessageWithSenderAndRecipients(Uuid $sender, array $recipients): Message
    {
        $message = MessageObjectMother::randomWithSenderAndRecipients($sender, $recipients);
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
        return $message;
    }

    protected function messageRepository(): MessageRepositoryInterface
    {
        return $this->getContainer()->get(MessageRepositoryInterface::class);
    }

    protected function notificationRepository(): NotificationRepositoryInterface
    {
        return $this->getContainer()->get(NotificationRepositoryInterface::class);
    }
}