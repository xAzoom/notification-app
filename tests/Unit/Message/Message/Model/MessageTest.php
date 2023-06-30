<?php
declare(strict_types=1);

namespace App\Tests\Unit\Message\Message\Model;

use App\Message\Message\Domain\Event\MessageCreatedDomainEvent;
use App\Message\Message\Domain\Exception\InvalidRecipientException;
use App\Message\Message\Domain\Exception\NotRecipientsDefinedException;
use App\Message\Message\Domain\Exception\RecipientsDuplicationException;
use App\Message\Message\Domain\Model\DTO\MessageDTO;
use App\Message\Message\Domain\Model\Message;
use App\Tests\Shared\ObjectMother\Message\Message\ContentObjectMother;
use App\Tests\Shared\TestDouble\Shared\ClockStub;
use App\Tests\Unit\BaseUnitTestCase;
use Symfony\Component\Uid\Uuid;

class MessageTest extends BaseUnitTestCase
{
    public function testUnsuccessfulCreateWithoutRecipients(): void
    {
        $this->expectException(NotRecipientsDefinedException::class);

        new Message(Uuid::v4(), Uuid::v4(), [], ContentObjectMother::validContent(), new ClockStub());
    }

    public function testUnsuccessfulCreateWithInvalidRecipients(): void
    {
        $this->expectException(InvalidRecipientException::class);

        new Message(Uuid::v4(), Uuid::v4(), [11], ContentObjectMother::validContent(), new ClockStub());
    }

    public function testUnsuccessfulCreateWithDuplicatedRecipients(): void
    {
        $this->expectException(RecipientsDuplicationException::class);

        $uuid = Uuid::v4();
        new Message(Uuid::v4(), Uuid::v4(), [$uuid, Uuid::fromString((string)$uuid)], ContentObjectMother::validContent(), new ClockStub());
    }

    public function testCreatedMessageEventRaised(): void
    {
        //given
        $id = Uuid::v4();
        //and
        $senderId = Uuid::v4();
        //and
        $recipients = [Uuid::v4()];
        //and
        $content = ContentObjectMother::validContent();

        //when
        $message = new Message($id, $senderId, $recipients, $content, new ClockStub());

        //then
        $events = $message->getDomainEvents();
        $this->assertCount(1, $events);
        //and
        /** @var MessageCreatedDomainEvent $event */
        $event = $events[0];
        $this->assertInstanceOf(MessageCreatedDomainEvent::class, $event);
        //and
        $this->assertEquals($id, $event->getAggregateId());
        //and
        $this->assertEquals(new MessageDTO($id, $senderId, $recipients, (string)$content), $event->getMessageDTO());
    }
}