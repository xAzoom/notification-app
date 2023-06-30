<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model\Type;

interface NotificationTypeInterface
{
    public static function type(): string;

    public static function fromArray(array $array): self;

    public function toArray(): array;
}