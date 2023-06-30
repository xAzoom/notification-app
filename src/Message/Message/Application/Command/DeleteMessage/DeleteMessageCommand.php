<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\DeleteMessage;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class DeleteMessageCommand implements CommandInterface
{
    private Uuid $messageId;

    public function __construct(Uuid $messageId)
    {
        $this->messageId = $messageId;
    }

    public function getMessageId(): Uuid
    {
        return $this->messageId;
    }
}