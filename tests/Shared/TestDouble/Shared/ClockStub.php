<?php
declare(strict_types=1);

namespace App\Tests\Shared\TestDouble\Shared;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class ClockStub implements ClockInterface
{
    private ?\DateTimeImmutable $instant;

    public function __construct(?\DateTimeImmutable $instant = null)
    {
        if (null === $instant) {
            $instant = new \DateTimeImmutable();
        }
        $this->instant = $instant;
    }

    public function now(): DateTimeImmutable
    {
        return $this->instant;
    }
}