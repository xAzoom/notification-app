<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\DTO;

use Symfony\Component\Uid\Uuid;

class RecipientDTO
{
    private Uuid $recipientId;
    private bool $read;

    public function __construct(
        Uuid $recipientId,
        bool $read
    )
    {
        $this->recipientId = $recipientId;
        $this->read = $read;
    }

    public function getRecipientId(): Uuid
    {
        return $this->recipientId;
    }

    public function isRead(): bool
    {
        return $this->read;
    }
}