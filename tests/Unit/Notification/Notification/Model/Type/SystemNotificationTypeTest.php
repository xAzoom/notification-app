<?php
declare(strict_types=1);

namespace App\Tests\Unit\Notification\Notification\Model\Type;

use App\Notification\Notification\Domain\Exception\TooLongContentException;
use App\Notification\Notification\Domain\Model\Type\SystemNotificationType;
use App\Tests\Unit\BaseUnitTestCase;

class SystemNotificationTypeTest extends BaseUnitTestCase
{
    public function testUnsuccessfulCreateWithTooLongContent(): void
    {
        $this->expectException(TooLongContentException::class);

        new SystemNotificationType(str_repeat('a', 101));
    }
}