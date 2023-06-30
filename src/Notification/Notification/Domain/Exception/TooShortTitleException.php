<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class TooShortTitleException extends DomainException
{
}