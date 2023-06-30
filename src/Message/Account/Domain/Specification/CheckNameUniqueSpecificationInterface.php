<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Specification;

use App\Message\Account\Domain\Model\Name;

interface CheckNameUniqueSpecificationInterface
{
    public function isUniqueName(Name $name): bool;
}