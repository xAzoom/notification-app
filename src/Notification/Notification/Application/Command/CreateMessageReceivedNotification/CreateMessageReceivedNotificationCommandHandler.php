<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Command\CreateMessageReceivedNotification;

use App\Notification\Notification\Domain\Model\Notification;
use App\Notification\Notification\Domain\Model\Title;
use App\Notification\Notification\Domain\Model\Type\MessageReceivedNotificationType;
use App\Notification\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Shared\Application\Bus\CommandBus\CommandHandlerInterface;
use Psr\Clock\ClockInterface;

class CreateMessageReceivedNotificationCommandHandler implements CommandHandlerInterface
{
    private NotificationRepositoryInterface $notificationRepository;

    private ClockInterface $clock;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        ClockInterface                  $clock
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->clock = $clock;
    }

    public function __invoke(CreateMessageReceivedNotificationCommand $command): void
    {
        $notification = new Notification(
            $command->getId(),
            Title::create($command->getTitle()),
            $command->getRecipients(),
            new MessageReceivedNotificationType(
                $command->getShortContent(),
                $command->getMessageId(),
                $command->getSenderId(),
                $command->getSenderName()
            ),
            $this->clock
        );

        $this->notificationRepository->save($notification);
    }
}