<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Query\ViewModel;

class MessageTransformer
{
    public function transform(array $message, array $accountIdToNameMap): MessageViewModel
    {
        return new MessageViewModel(
            (string) $message['id'],
            $accountIdToNameMap[(string) $message['senderId']],
            $message['content.value']
        );
    }

    public function transformMultiple(array $messages, array $accountIdToNameMap): array
    {
        return array_map(fn (array $message) => $this->transform($message, $accountIdToNameMap), $messages);
    }
}