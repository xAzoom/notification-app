<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Command\EditMessage;

use App\Message\Message\Domain\Model\Content;
use App\Message\Message\Domain\Repository\MessageRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;

class EditMessageCommandHandler implements CommandHandlerInterface
{
    private MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function __invoke(EditMessageCommand $command): void
    {
        if (!$message = $this->messageRepository->findOneById($command->getMessageId())) {
            throw new \Exception(sprintf('Message "%s" does not exist', $command->getMessageId()));
        }

        $message->changeContent(Content::create($command->getContent()));
        $this->messageRepository->save($message);
    }
}