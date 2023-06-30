<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\CreateMessage;

use App\Message\Message\Domain\Model\Content;
use App\Message\Message\Domain\Model\Message;
use App\Message\Message\Domain\Repository\MessageRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;
use App\Shared\Application\Bus\DomainEventBus\DomainEventBusInterface;
use Psr\Clock\ClockInterface;

class CreateMessageCommandHandler implements CommandHandlerInterface
{
    private ClockInterface $clock;

    private MessageRepositoryInterface $messageRepository;

    private DomainEventBusInterface $domainEventBus;

    public function __construct(
        ClockInterface $clock,
        MessageRepositoryInterface $messageRepository,
        DomainEventBusInterface $domainEventBus
    )
    {
        $this->clock = $clock;
        $this->messageRepository = $messageRepository;
        $this->domainEventBus = $domainEventBus;
    }

    public function __invoke(CreateMessageCommand $command): void
    {
        $message = new Message(
            $command->getId(),
            $command->getSender(),
            $command->getRecipients(),
            Content::create($command->getContent()),
            $this->clock
        );

        $events = $message->getDomainEvents();
        $message->clearDomainEvents();
        $this->messageRepository->save($message);
        $this->domainEventBus->dispatchAll($events);
    }
}