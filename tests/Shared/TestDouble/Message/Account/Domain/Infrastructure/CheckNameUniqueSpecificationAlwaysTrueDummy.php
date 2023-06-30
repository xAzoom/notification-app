<?php
declare(strict_types=1);

namespace App\Tests\Shared\TestDouble\Message\Account\Domain\Infrastructure;

use App\Message\Account\Domain\Model\Name;
use App\Message\Account\Domain\Specification\CheckNameUniqueSpecificationInterface;

class CheckNameUniqueSpecificationAlwaysTrueDummy implements CheckNameUniqueSpecificationInterface
{
    public function isUniqueName(Name $name): bool
    {
        return true;
    }
}