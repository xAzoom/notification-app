<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Model;

use App\Message\Message\Domain\Exception\TooShortContentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Content
{
    /**
     * @ORM\Column(type="text")
     */
    private string $value;

    private function __construct(string $value)
    {
        if (mb_strlen($value) < 5) {
            throw new TooShortContentException(sprintf('Contnent "%s" is too short', $value));
        }

        $this->value = $value;
    }

    public static function create(string $content): self
    {
        return new self($content);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}