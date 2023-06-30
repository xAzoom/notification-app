<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Message\Account;

use App\Message\Account\Domain\Model\Name;
use Symfony\Component\Uid\Uuid;

class NameObjectMother
{
    public static function random(): Name
    {
        return Name::create((string) Uuid::v4());
    }
}