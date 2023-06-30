<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Model\DTO;

use Symfony\Component\Uid\Uuid;

class MessageDTO
{
    private Uuid $id;

    private Uuid $senderId;

    /** @var Uuid[] */
    private array $recipients;

    private string $content;

    public function __construct(
        Uuid $id,
        Uuid $senderId,
        array $recipients,
        string $content
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->recipients = $recipients;
        $this->content = $content;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSenderId(): Uuid
    {
        return $this->senderId;
    }

    /** @return Uuid[] */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}