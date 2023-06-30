<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Command\CreateAccount;

use App\Message\Account\Domain\Model\Account;
use App\Message\Account\Domain\Model\Name;
use App\Message\Account\Domain\Repository\AccountRepositoryInterface;
use App\Message\Account\Domain\Specification\CheckNameUniqueSpecificationInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;
use App\Shared\Application\Bus\DomainEventBus\DomainEventBusInterface;

class CreateAccountCommandHandler implements CommandHandlerInterface
{
    private CheckNameUniqueSpecificationInterface $checkNameUniqueSpecification;

    private AccountRepositoryInterface $accountRepository;

    private DomainEventBusInterface $domainEventBus;

    public function __construct(
        CheckNameUniqueSpecificationInterface $checkNameUniqueSpecification,
        AccountRepositoryInterface            $accountRepository,
        DomainEventBusInterface               $domainEventBus
    )
    {
        $this->checkNameUniqueSpecification = $checkNameUniqueSpecification;
        $this->accountRepository = $accountRepository;
        $this->domainEventBus = $domainEventBus;
    }

    public function __invoke(CreateAccountCommand $command): void
    {
        $account = new Account(
            $command->getId(),
            Name::create($command->getName()),
            $this->checkNameUniqueSpecification,
        );

        $events = $account->getDomainEvents();
        $account->clearDomainEvents();
        $this->accountRepository->save($account);
        $this->domainEventBus->dispatchAll($events);
    }
}