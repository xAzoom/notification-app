<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\EventBus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class EventBus implements EventBusInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(EventInterface $event): void
    {
        $this->messageBus->dispatch(
            (new Envelope($event))
                ->with(new DispatchAfterCurrentBusStamp())
        );
    }
}