<?php
declare(strict_types=1);

namespace App\Shared;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class Clock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}