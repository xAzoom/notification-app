<?php
declare(strict_types=1);

namespace App\UI\REST\Account\DTO;

use App\UI\REST\Core\RequestDTOInterface;

class AccountDTO implements RequestDTOInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}