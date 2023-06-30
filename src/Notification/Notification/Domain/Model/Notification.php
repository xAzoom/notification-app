<?php
declare(strict_types=1);

namespace App\Notification\Notification\Domain\Model;

use App\Notification\Notification\Domain\DTO\RecipientDTO;
use App\Notification\Notification\Domain\Exception\InvalidRecipientException;
use App\Notification\Notification\Domain\Exception\NotRecipientsDefinedException;
use App\Notification\Notification\Domain\Exception\RecipientNotFoundInNotificationException;
use App\Notification\Notification\Domain\Exception\RecipientsDuplicationException;
use App\Notification\Notification\Domain\Model\Type\NotificationTypeInterface;
use App\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Psr\Clock\ClockInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Notification extends AggregateRoot
{
    /**
     * @ORM\Embedded(class=Title::class, columnPrefix=false)
     */
    private Title $title;

    /**
     * @ORM\OneToMany(targetEntity=Recipient::class, mappedBy="notification", cascade={"persist", "remove"}, fetch="EAGER", orphanRemoval=true)
     */
    private Collection $recipients;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $sentAt;

    /**
     * @ORM\Column(type="notification_type")
     */
    private NotificationTypeInterface $type;

    public function __construct(
        Uuid                      $id,
        Title                     $title,
        array                     $recipients,
        NotificationTypeInterface $type,
        ClockInterface            $clock
    )
    {
        if (empty($recipients)) {
            throw new NotRecipientsDefinedException('At least one recipient has to be defined.');
        }

        if (count($recipients) !== count(array_unique($recipients))) {
            throw new RecipientsDuplicationException('List of recipients cannot contain duplicates');
        }

        $this->recipients = new ArrayCollection();
        foreach ($recipients as $recipient) {
            if (!$recipient instanceof Uuid) {
                throw new InvalidRecipientException('Not recognized recipient id');
            }

            $this->recipients[] = new Recipient($this, $recipient);
        }

        $this->id = $id;
        $this->title = $title;
        $this->sentAt = $clock->now();
        $this->type = $type;
    }

    public function makeAsRead(Uuid $recipientId): void
    {
        $recipient = $this->findRecipient($recipientId);
        $recipient->makeAsRead();
    }

    public function makeAsUnread(Uuid $recipientId): void
    {
        $recipient = $this->findRecipient($recipientId);
        $recipient->makeAsUnread();
    }

    public function delete(Uuid $recipientId): void
    {
        $recipient = $this->findRecipient($recipientId);
        $this->recipients->removeElement($recipient);
        $recipient->delete();
    }

    private function findRecipient(Uuid $recipientId): Recipient
    {
        /** @var Recipient $recipient */
        foreach ($this->recipients as $recipient) {
            if ($recipient->isEqRecipient($recipientId)) {
                return $recipient;
            }
        }

        throw new RecipientNotFoundInNotificationException(
            sprintf('Not found "%s" recipient in "%s" notification', $recipientId, $this->id)
        );
    }

    /**
     * @return RecipientDTO[]
     */
    public function getRecipients(): array
    {
        return array_values($this->recipients
            ->map(fn (Recipient $recipient) => $recipient->toDTO())
            ->toArray());
    }
}