<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Event;

use App\Message\Message\Domain\Model\DTO\MessageDTO;
use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Uid\Uuid;

class MessageCreatedDomainEvent implements DomainEvent
{
    private Uuid $aggregateId;

    private MessageDTO $messageDTO;

    public function __construct(
        Uuid $aggregateId,
        MessageDTO $messageDTO
    )
    {
        $this->aggregateId = $aggregateId;
        $this->messageDTO = $messageDTO;
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function getMessageDTO(): MessageDTO
    {
        return $this->messageDTO;
    }
}