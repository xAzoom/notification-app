<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Command\CreateAccount;

use App\Shared\Application\Bus\CommandBus\CommandInterface;
use Symfony\Component\Uid\Uuid;

class CreateAccountCommand implements CommandInterface
{
    private Uuid $id;
    private string $name;

    public function __construct(
        Uuid   $id,
        string $name
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}