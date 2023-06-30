<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Model;

use App\Message\Message\Domain\Event\MessageCreatedDomainEvent;
use App\Message\Message\Domain\Exception\InvalidRecipientException;
use App\Message\Message\Domain\Exception\NotRecipientsDefinedException;
use App\Message\Message\Domain\Exception\RecipientsDuplicationException;
use App\Message\Message\Domain\Model\DTO\MessageDTO;
use App\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Psr\Clock\ClockInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Message extends AggregateRoot
{
    /**
     * @ORM\Column(type="uuid")
     */
    private Uuid $senderId;

    /**
     * @ORM\OneToMany(targetEntity=Recipient::class, mappedBy="message", cascade={"persist", "remove"})
     */
    private Collection $recipients;

    /**
     * @ORM\Embedded(class=Content::class, columnPrefix=false)
     */
    private Content $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $sentAt;

    public function __construct(
        Uuid           $id,
        Uuid           $accountSenderId,
        array          $recipients,
        Content        $content,
        ClockInterface $clock
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
        $this->senderId = $accountSenderId;
        $this->content = $content;
        $this->sentAt = $clock->now();

        $this->raise(new MessageCreatedDomainEvent($this->id, $this->toDTO()));
    }

    public function changeContent(Content $content): void
    {
        $this->content = $content;
    }

    public function toDTO(): MessageDTO
    {
        return new MessageDTO(
            $this->id,
            $this->senderId,
            array_map(fn(Recipient $recipient) => $recipient->getRecipientId(), $this->recipients->toArray()),
            (string)$this->content
        );
    }
}