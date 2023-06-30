<?php
declare(strict_types=1);

namespace App\UI\REST\Message\Action;

use App\Message\Message\Application\Command\CreateMessage\CreateMessageCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\UI\REST\Message\DTO\CreateMessageDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CreateMessageAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/messages", methods={"POST"}, name="message_create")
     */
    public function __invoke(CreateMessageDTO $createMessageDTO): Response
    {
        $id = Uuid::v4();
        $this->commandBus->handle(new CreateMessageCommand(
            $id,
            Uuid::fromString($createMessageDTO->getSender()),
            array_map(fn(string $recipientId) => Uuid::fromString($recipientId), $createMessageDTO->getRecipients()),
            $createMessageDTO->getContent(),
        ));

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}