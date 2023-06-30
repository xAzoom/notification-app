<?php
declare(strict_types=1);

namespace App\Notification\Account\Application\Command\CreateAccount;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class CreateAccountCommand implements CommandInterface
{
    private Uuid $id;

    public function __construct(
        Uuid $id
    )
    {
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}