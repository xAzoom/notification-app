<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\DomainEventBus;

use App\Shared\Domain\Event\DomainEvent;

interface DomainEventBusInterface
{
    /**
     * @param DomainEvent[] $events
     */
    public function dispatchAll(array $events): void;
}