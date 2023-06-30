<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model;

use App\Notification\Notification\Domain\DTO\RecipientDTO;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Recipient
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private Uuid $id;

    /**
     * @ORM\ManyToOne(targetEntity=Notification::class, inversedBy="recipients")
     */
    private ?Notification $notification = null;

    /**
     * @ORM\Column(type="uuid")
     */
    private Uuid $recipientId;

    /**
     * @ORM\Column(type="boolean", name="`read`")
     */
    private bool $read = false;

    public function __construct(Notification $notification, Uuid $recipientId)
    {
        $this->id = Uuid::v4();
        $this->notification = $notification;
        $this->recipientId = $recipientId;
    }

    public function makeAsRead(): void
    {
        $this->read = true;
    }

    public function makeAsUnread(): void
    {
        $this->read = false;
    }

    public function isEqRecipient(Uuid $id): bool
    {
        return $id->equals($this->recipientId);
    }

    public function delete(): void
    {
        $this->notification = null;
    }

    public function toDTO(): RecipientDTO
    {
        return new RecipientDTO($this->recipientId, $this->read);
    }
}