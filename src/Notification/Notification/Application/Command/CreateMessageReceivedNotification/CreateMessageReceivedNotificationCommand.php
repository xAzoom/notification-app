<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Command\CreateMessageReceivedNotification;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class CreateMessageReceivedNotificationCommand implements CommandInterface
{
    private Uuid $id;

    private string $title;

    private array $recipients;

    private Uuid $senderId;

    private string $senderName;

    private Uuid $messageId;

    private string $shortContent;

    public function __construct(
        Uuid $id,
        string $title,
        array $recipients,
        Uuid $senderId,
        string $senderName,
        Uuid $messageId,
        string $shortContent
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->recipients = $recipients;
        $this->senderId = $senderId;
        $this->messageId = $messageId;
        $this->shortContent = $shortContent;
        $this->senderName = $senderName;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSenderId(): Uuid
    {
        return $this->senderId;
    }

    public function getMessageId(): Uuid
    {
        return $this->messageId;
    }

    public function getShortContent(): string
    {
        return $this->shortContent;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }
}