<?php
declare(strict_types=1);

namespace App\Notification\Account\Application\Command\CreateAccount;

use App\Notification\Account\Domain\Model\Account;
use App\Notification\Account\Domain\Repository\AccountRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;

class CreateAccountCommandHandler implements CommandHandlerInterface
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function __invoke(CreateAccountCommand $command): void
    {
        $account = new Account($command->getId());
        $this->accountRepository->save($account);
    }
}