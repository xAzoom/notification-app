<?php
declare(strict_types=1);

namespace App\Notification\Notification\Infrastructure\Doctrine;

use App\Notification\Notification\Domain\Model\Type\MessageReceivedNotificationType;
use App\Notification\Notification\Domain\Model\Type\NotificationTypeInterface;
use App\Notification\Notification\Domain\Model\Type\SystemNotificationType;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

class NotificationType extends JsonType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (!$value instanceof NotificationTypeInterface) {
            throw new Exception('Value is not instance of Notification Type');
        }

        return parent::convertToDatabaseValue($value->toArray(), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): NotificationTypeInterface
    {
        if ($value === null) {
            ConversionException::conversionFailed(null, 'NotificationType');
        }

        $data = parent::convertToPHPValue($value, $platform);

        if (!isset($data['notificationType'])) {
            ConversionException::conversionFailed($data, 'NotificationType');
        }

        /** @var NotificationTypeInterface[] $map */
        $map = [
            MessageReceivedNotificationType::type() => MessageReceivedNotificationType::class,
            SystemNotificationType::type() => SystemNotificationType::class,
        ];

        return $map[$data['notificationType']]::fromArray($data);
    }
}