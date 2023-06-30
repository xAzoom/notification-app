<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Message\Message;

use App\Message\Message\Domain\Model\Content;
use App\Message\Message\Domain\Model\Message;
use App\Tests\Shared\TestDouble\Shared\ClockStub;
use Symfony\Component\Uid\Uuid;

class MessageObjectMother
{
    public static function random(): Message
    {
        return new Message(Uuid::v4(), Uuid::v4(), [Uuid::v4()], Content::create('TESTOWY'), new ClockStub());
    }

    public static function randomWithSenderAndRecipients(Uuid $sender, array $recipients): Message
    {
        return new Message(Uuid::v4(), $sender, $recipients, Content::create('TESTOWY'), new ClockStub(new \DateTimeImmutable()));
    }
}