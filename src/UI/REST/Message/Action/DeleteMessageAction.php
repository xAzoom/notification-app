<?php
declare(strict_types=1);

namespace App\UI\REST\Message\Action;

use App\Message\Message\Application\Command\DeleteMessage\DeleteMessageCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class DeleteMessageAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/messages/{id}", methods={"DELETE"}, name="message_delete")
     */
    public function __invoke(string $id): Response
    {
        $this->commandBus->handle(new DeleteMessageCommand(Uuid::fromString($id)));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}