<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\CommandBus;

use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle(CommandInterface $command): void
    {
        $this->messageBus->dispatch($command);
    }
}