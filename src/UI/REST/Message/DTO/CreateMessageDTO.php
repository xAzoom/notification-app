<?php
declare(strict_types=1);

namespace App\UI\REST\Message\DTO;

use App\UI\REST\Core\RequestDTOInterface;

class CreateMessageDTO implements RequestDTOInterface
{
    private string $sender;

    private array $recipients;

    private string $content;

    public function __construct(
        string $sender,
        array $recipients,
        string $content
    ) {
        $this->sender = $sender;
        $this->recipients = $recipients;
        $this->content = $content;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}