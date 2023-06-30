<?php
declare(strict_types=1);

namespace App\Shared\Application\Bus\CommandBus;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}