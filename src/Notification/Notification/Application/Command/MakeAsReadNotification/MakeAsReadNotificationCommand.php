<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Command\MakeAsReadNotification;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class MakeAsReadNotificationCommand implements CommandInterface
{
    private Uuid $notificationId;

    private Uuid $recipientId;

    public function __construct(
        Uuid $notificationId,
        Uuid $recipientId
    )
    {
        $this->notificationId = $notificationId;
        $this->recipientId = $recipientId;
    }

    public function getNotificationId(): Uuid
    {
        return $this->notificationId;
    }

    public function getRecipientId(): Uuid
    {
        return $this->recipientId;
    }
}