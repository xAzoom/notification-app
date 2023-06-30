<?php
declare(strict_types=1);

namespace App\Notification\Account\Domain\Model;

use App\Shared\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Account extends AggregateRoot
{
    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }
}