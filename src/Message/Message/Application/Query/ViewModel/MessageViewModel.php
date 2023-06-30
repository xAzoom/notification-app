<?php
declare(strict_types=1);

namespace App\Message\Message\Application\Query\ViewModel;

class MessageViewModel
{
    private string $id;

    private string $senderName;

    private string $content;

    public function __construct(
        string $id,
        string $senderName,
        string $content
    )
    {
        $this->id = $id;
        $this->senderName = $senderName;
        $this->content = $content;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}