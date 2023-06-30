<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Uid\Uuid;

class AccountCreatedDomainEvent implements DomainEvent
{
    private Uuid $aggregateId;

    public function __construct(
        Uuid $aggregateId
    )
    {
        $this->aggregateId = $aggregateId;
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }
}