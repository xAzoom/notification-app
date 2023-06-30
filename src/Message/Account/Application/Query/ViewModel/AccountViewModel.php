<?php
declare(strict_types=1);

namespace App\Message\Account\Application\Query\ViewModel;

class AccountViewModel
{
    private string $id;

    private string $name;

    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}