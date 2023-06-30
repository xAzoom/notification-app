<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Message\Account;

use App\Message\Account\Domain\Model\Account;
use App\Tests\Shared\TestDouble\Message\Account\Domain\Infrastructure\CheckNameUniqueSpecificationAlwaysTrueDummy;
use Symfony\Component\Uid\Uuid;

class AccountObjectMother
{
    public static function random(): Account
    {
        return new Account(Uuid::v4(), NameObjectMother::random(), new CheckNameUniqueSpecificationAlwaysTrueDummy());
    }
}