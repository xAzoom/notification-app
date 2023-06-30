<?php
declare(strict_types=1);

namespace App\Message\Account\Application\DomainEvent\AccountCreatedDomainEvent;

use App\Message\Account\Domain\Event\AccountCreatedDomainEvent;
use App\Notification\Account\Application\Command\CreateAccount\CreateAccountCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\Shared\Application\Bus\DomainEventBus\DomainEventHandlerInterface;

class CreateNotificationAccountEventHandler implements DomainEventHandlerInterface
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(AccountCreatedDomainEvent $event): void
    {
        $this->commandBus->handle(new CreateAccountCommand($event->getAggregateId()));
    }
}