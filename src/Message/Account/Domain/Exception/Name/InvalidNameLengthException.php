<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Exception\Name;

use App\Shared\Domain\Exception\DomainException;

class InvalidNameLengthException extends DomainException
{
}