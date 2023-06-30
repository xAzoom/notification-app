<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Command\MakeAsReadNotification;

use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;

class MakeAsReadNotificationCommandHandler implements CommandHandlerInterface
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function __invoke(MakeAsReadNotificationCommand $command): void
    {
        if (!$notification = $this->notificationRepository->findOneById($command->getNotificationId())) {
            throw new \InvalidArgumentException(sprintf('Notification %s does not exist', $command->getNotificationId()));
        }
        $notification->makeAsRead($command->getRecipientId());
        $this->notificationRepository->save($notification);
    }
}