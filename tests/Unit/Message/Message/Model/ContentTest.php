<?php
declare(strict_types=1);

namespace App\Tests\Unit\Message\Message\Model;

use App\Message\Message\Domain\Exception\TooShortContentException;
use App\Message\Message\Domain\Model\Content;
use App\Tests\Unit\BaseUnitTestCase;

class ContentTest extends BaseUnitTestCase
{
    public function testCreateTooShortContent(): void
    {
        $this->expectException(TooShortContentException::class);

        Content::create('abcd');
    }
}