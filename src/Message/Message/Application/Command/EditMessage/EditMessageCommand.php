<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\EditMessage;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class EditMessageCommand implements CommandInterface
{
    private Uuid $messageId;

    private string $content;

    public function __construct(
        Uuid $messageId,
        string $content
    )
    {
        $this->messageId = $messageId;
        $this->content = $content;
    }

    public function getMessageId(): Uuid
    {
        return $this->messageId;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}