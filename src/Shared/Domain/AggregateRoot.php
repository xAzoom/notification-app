<?php
declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
abstract class AggregateRoot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected Uuid $id;

    /** @var DomainEvent[] */
    private array $events = [];

    public function getId(): Uuid
    {
        return $this->id;
    }

    protected function raise(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function getDomainEvents(): array
    {
        return $this->events;
    }

    public function clearDomainEvents(): void
    {
        $this->events = [];
    }
}