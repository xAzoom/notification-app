<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\DeleteMessage;

use App\Message\Message\Domain\Repository\MessageRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;

class DeleteMessageCommandHandler implements CommandHandlerInterface
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function __invoke(DeleteMessageCommand $command): void
    {
        if (!$message = $this->messageRepository->findOneById($command->getMessageId())) {
            throw new \Exception(sprintf('Message "%s" does not exist', $command->getMessageId()));
        }

        $this->messageRepository->remove($message);
    }
}