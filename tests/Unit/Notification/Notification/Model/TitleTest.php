<?php
declare(strict_types=1);

namespace App\Tests\Unit\Notification\Notification\Model;

use App\Notification\Notification\Domain\Exception\TooShortTitleException;
use App\Notification\Notification\Domain\Model\Title;
use App\Tests\Unit\BaseUnitTestCase;

class TitleTest extends BaseUnitTestCase
{
    public function testUnsuccessfulCreateTooShortTitle(): void
    {
        $this->expectException(TooShortTitleException::class);

        Title::create('a');
    }
}