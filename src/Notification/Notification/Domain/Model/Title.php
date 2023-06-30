<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model;

use App\Notification\Notification\Domain\Exception\TooShortTitleException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Title
{
    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    private function __construct(string $title)
    {
        if (mb_strlen($title) < 3) {
            throw new TooShortTitleException('Short should has at least 3 characters');
        }

        $this->title = $title;
    }

    public static function create(string $title): self
    {
        return new self($title);
    }

    public function __toString(): string
    {
        return $this->title;
    }
}