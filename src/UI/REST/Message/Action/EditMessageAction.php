<?php
declare(strict_types=1);

namespace App\UI\REST\Message\Action;

use App\Message\Message\Application\Command\EditMessage\EditMessageCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\UI\REST\Message\DTO\EditMessageDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class EditMessageAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/messages/{id}", methods={"PATCH"}, name="message_edit")
     */
    public function __invoke(string $id, EditMessageDTO $editMessageDTO): Response
    {
        $this->commandBus->handle(new EditMessageCommand(
            Uuid::fromString($id),
            $editMessageDTO->getContent(),
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}