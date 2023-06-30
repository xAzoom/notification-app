<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\EventBus;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}