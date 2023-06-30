<?php
declare(strict_types=1);

namespace App\UI\REST\Notification\DTO;

use App\UI\REST\Core\RequestDTOInterface;

class NotificationDTO implements RequestDTOInterface
{
    private string $recipientId;

    public function __construct(
        string $recipientId
    )
    {
        $this->recipientId = $recipientId;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }
}