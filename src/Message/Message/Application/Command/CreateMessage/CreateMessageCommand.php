<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\CreateMessage;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class CreateMessageCommand implements CommandInterface
{
    private Uuid $id;

    private Uuid $sender;

    private array $recipients;

    private string $content;

    public function __construct(
        Uuid   $id,
        Uuid   $sender,
        array  $recipients,
        string $content
    )
    {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipients = $recipients;
        $this->content = $content;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSender(): Uuid
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