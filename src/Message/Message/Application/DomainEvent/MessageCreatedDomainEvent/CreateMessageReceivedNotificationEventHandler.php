<?php
declare(strict_types=1);

namespace App\Message\Message\Application\DomainEvent\MessageCreatedDomainEvent;

use App\Message\Account\Domain\Repository\AccountRepositoryInterface;
use App\Message\Message\Domain\Event\MessageCreatedDomainEvent;
use App\Notification\Notification\Application\Command\CreateMessageReceivedNotification\CreateMessageReceivedNotificationCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\Shared\Application\Bus\DomainEventBus\DomainEventHandlerInterface;
use Symfony\Component\Uid\Uuid;

class CreateMessageReceivedNotificationEventHandler implements DomainEventHandlerInterface
{
    private CommandBusInterface $commandBus;

    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        CommandBusInterface        $commandBus,
        AccountRepositoryInterface $accountRepository
    )
    {
        $this->commandBus = $commandBus;
        $this->accountRepository = $accountRepository;
    }

    public function __invoke(MessageCreatedDomainEvent $event): void
    {
        $messageDTO = $event->getMessageDTO();
        $account = $this->accountRepository->findOneById($messageDTO->getSenderId());

        $this->commandBus->handle(new CreateMessageReceivedNotificationCommand(
            Uuid::v4(),
            'Otrzymałeś nową wiadomość od ' . $account->getName(),
            $messageDTO->getRecipients(),
            $messageDTO->getSenderId(),
            $account->getName(),
            $messageDTO->getId(),
            mb_substr($messageDTO->getContent(), 0, 100),
        ));
    }
}