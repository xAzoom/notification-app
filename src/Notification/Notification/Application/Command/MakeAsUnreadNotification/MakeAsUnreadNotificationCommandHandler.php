<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Command\MakeAsUnreadNotification;

use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;

class MakeAsUnreadNotificationCommandHandler implements CommandHandlerInterface
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function __invoke(MakeAsUnreadNotificationCommand $command): void
    {
        if (!$notification = $this->notificationRepository->findOneById($command->getNotificationId())) {
            throw new \InvalidArgumentException(sprintf('Notification %s does not exist', $command->getNotificationId()));
        }
        $notification->makeAsUnread($command->getRecipientId());
        $this->notificationRepository->save($notification);
    }
}