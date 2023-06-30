<?php
declare(strict_types=1);

namespace App\UI\REST\Message\DTO;

use App\UI\REST\Core\RequestDTOInterface;

class EditMessageDTO implements RequestDTOInterface
{
    private string $content;

    public function __construct(
        string $content
    )
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}