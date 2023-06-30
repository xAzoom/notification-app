<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class TooShortContentException extends DomainException
{
}