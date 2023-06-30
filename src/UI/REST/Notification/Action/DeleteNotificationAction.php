<?php
declare(strict_types=1);

namespace App\UI\REST\Notification\Action;

use App\Notification\Notification\Application\Command\DeleteNotification\DeleteNotificationCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\UI\REST\Notification\DTO\NotificationDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class DeleteNotificationAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/notifications/{id}", methods={"DELETE"}, name="notification_delete")
     */
    public function __invoke(string $id, NotificationDTO $notificationDTO): Response
    {
        $this->commandBus->handle(new DeleteNotificationCommand(
            Uuid::fromString($id),
            Uuid::fromString($notificationDTO->getRecipientId()),
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}