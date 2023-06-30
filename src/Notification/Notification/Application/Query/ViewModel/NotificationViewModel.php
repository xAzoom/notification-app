<?php
declare(strict_types=1);

namespace App\Notification\Notification\Application\Query\ViewModel;

class NotificationViewModel
{
    private string $id;

    private string $title;

    private ?string $content;

    private bool $read;

    public function __construct(
        string $id,
        string $title,
        ?string $content,
        bool $read
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->read = $read;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function isRead(): bool
    {
        return $this->read;
    }
}