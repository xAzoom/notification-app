<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Query;

use Symfony\Component\Uid\Uuid;

interface ListDirectsMessagesQuery
{
    public function listDirectMessages(Uuid $firstAccount, Uuid $secondAccount);
}