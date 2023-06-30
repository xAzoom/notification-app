<?php
declare(strict_types=1);

namespace App\Message\Message\Domain\Repository;

use App\Message\Message\Domain\Model\Message;
use Symfony\Component\Uid\Uuid;

interface MessageRepositoryInterface
{
    public function findOneById(Uuid $id): ?Message;

    public function save(Message $message): void;

    public function remove(Message $message): void;
}