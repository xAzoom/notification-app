<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Query\ViewModel\Transformer;

use App\Notification\Notification\Application\Query\ViewModel\NotificationViewModel;

class NotificationTransformer
{
    public function transform(array $notification): NotificationViewModel
    {
        return new NotificationViewModel(
            (string)$notification['id'],
            $notification['title.title'],
            $notification['type']->getContent(),
            $notification['recipients'][0]['read']
        );
    }

    public function transformMultiple(array $notifications): array
    {
        return array_map(fn(array $notification) => $this->transform($notification), $notifications);
    }
}