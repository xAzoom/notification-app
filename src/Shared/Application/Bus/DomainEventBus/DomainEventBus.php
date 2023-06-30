<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\DomainEventBus;

use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Webmozart\Assert\Assert;

class DomainEventBus implements DomainEventBusInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatchAll(array $events): void
    {
        Assert::allIsInstanceOf($events, DomainEvent::class);

        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    private function dispatch(DomainEvent $event): void
    {
        $this->messageBus->dispatch(
            (new Envelope($event))
                ->with(new DispatchAfterCurrentBusStamp())
        );
    }
}