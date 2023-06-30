<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model\Type;

use App\Notification\Notification\Domain\Exception\TooLongContentException;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class MessageReceivedNotificationType implements NotificationTypeInterface
{
    private string $content;
    private Uuid $messageId;
    private Uuid $senderId;
    private string $senderName;

    public function __construct(
        string $content,
        Uuid   $messageId,
        Uuid   $senderId,
        string $senderName
    )
    {
        if (mb_strlen($content) > 100) {
            throw new TooLongContentException('Notification content is too long');
        }

        $this->content = $content;
        $this->messageId = $messageId;
        $this->senderId = $senderId;
        $this->senderName = $senderName;
    }

    public static function type(): string
    {
        return 'message_received';
    }

    public static function fromArray(array $array): NotificationTypeInterface
    {
        Assert::keyExists($array, 'content');
        Assert::keyExists($array, 'messageId');
        Assert::keyExists($array, 'senderId');
        Assert::keyExists($array, 'senderName');

        return new self(
            $array['content'],
            Uuid::fromString($array['messageId']),
            Uuid::fromString($array['senderId']),
            $array['senderName']
        );
    }

    public function toArray(): array
    {
        return [
            'notificationType' => self::type(),
            'content' => $this->content,
            'messageId' => (string)$this->messageId,
            'senderId' => (string)$this->senderId,
            'senderName' => $this->senderName
        ];
    }

    public function getContent(): string
    {
        return $this->content;
    }
}