<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Notification\ClickAction;
use App\Entity\Notification\NotificationInterface as EntityNotification;

interface NotificationInterface
{
    public function messageForNotification(NotificationInterface $notification): string;

    public function messageForNotifications(array $notifications): string;

    public function message(): string;

    public function fromEntity(EntityNotification $notification): void;

    public function toArray(): array;

    public function getType(): string;

    public function getClickAction(): ?ClickAction;
}
