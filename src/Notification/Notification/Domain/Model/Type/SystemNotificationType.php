<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model\Type;

use App\Notification\Notification\Domain\Exception\TooLongContentException;
use Webmozart\Assert\Assert;

class SystemNotificationType implements NotificationTypeInterface
{
    private ?string $content;

    public function __construct(?string $content)
    {
        if (null !== $content && mb_strlen($content) > 100) {
            throw new TooLongContentException('Notification content is too long');
        }
        $this->content = $content;
    }

    public static function type(): string
    {
        return 'system_notification';
    }

    public static function fromArray(array $array): NotificationTypeInterface
    {
        Assert::keyExists($array, 'content');
        return new self($array['content']);
    }

    public function toArray(): array
    {
        return [
            'notificationType' => self::type(),
            'content' => $this->content,
        ];
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}