<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Model;

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
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="recipients")
     */
    private Message $message;

    /**
     * @ORM\Column(type="uuid")
     */
    private Uuid $recipientId;

    public function __construct(Message $message, Uuid $accountId)
    {
        $this->id = Uuid::v4();
        $this->message = $message;
        $this->recipientId = $accountId;
    }

    public function getRecipientId(): Uuid
    {
        return $this->recipientId;
    }
}