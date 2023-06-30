<?php
declare(strict_types=1);

namespace App\UI\REST\Notification\Action;

use App\Notification\Notification\Application\Command\MakeAsReadNotification\MakeAsReadNotificationCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\UI\REST\Notification\DTO\NotificationDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class MakeReadNotificationAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/notifications/{id}/read", methods={"POST"}, name="notification_read")
     */
    public function __invoke(string $id, NotificationDTO $notificationDTO): Response
    {
        $this->commandBus->handle(new MakeAsReadNotificationCommand(
            Uuid::fromString($id),
            Uuid::fromString($notificationDTO->getRecipientId()),
        ));

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}