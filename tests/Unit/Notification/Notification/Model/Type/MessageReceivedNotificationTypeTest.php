<?php
declare(strict_types=1);

namespace App\Tests\Unit\Notification\Notification\Model\Type;

use App\Notification\Notification\Domain\Exception\TooLongContentException;
use App\Notification\Notification\Domain\Model\Type\MessageReceivedNotificationType;
use App\Tests\Unit\BaseUnitTestCase;
use Symfony\Component\Uid\Uuid;

class MessageReceivedNotificationTypeTest extends BaseUnitTestCase
{
    public function testUnsuccessfulCreateWithTooLongContent(): void
    {
        $this->expectException(TooLongContentException::class);

        new MessageReceivedNotificationType(str_repeat('a', 101), Uuid::v4(), Uuid::v4(), 'test');
    }
}