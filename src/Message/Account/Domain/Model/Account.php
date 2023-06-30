<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Model;

use App\Message\Account\Domain\DTO\AccountDTO;
use App\Message\Account\Domain\Event\AccountCreatedDomainEvent;
use App\Message\Account\Domain\Exception\Name\NotUniqueNameException;
use App\Message\Account\Domain\Specification\CheckNameUniqueSpecificationInterface;
use App\Shared\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Account extends AggregateRoot
{
    /**
     * @ORM\Embedded(class=Name::class, columnPrefix=false)
     */
    private Name $name;

    public function __construct(
        Uuid                                  $id,
        Name                                  $name,
        CheckNameUniqueSpecificationInterface $checkNameUniqueSpecification
    )
    {
        if (!$checkNameUniqueSpecification->isUniqueName($name)) {
            throw new NotUniqueNameException(sprintf('Name %s already exists', $name));
        }

        $this->id = $id;
        $this->name = $name;

        $this->raise(new AccountCreatedDomainEvent($this->id));
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}