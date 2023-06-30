<?php
declare(strict_types=1);

namespace App\Message\Account\Domain\Model;

use App\Message\Account\Domain\Exception\Name\InvalidNameLengthException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Name
{
    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $name;

    public function __construct(string $name)
    {
        $length = mb_strlen($name);
        if ($length < 3 || $length > 100) {
            throw new InvalidNameLengthException(sprintf('Name "%s" should has between 3-100 characters.', $name));
        }

        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}