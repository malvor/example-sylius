<?php

declare(strict_types=1);

namespace App\Entity\Notification;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface NotificationInterface extends ResourceInterface
{
    public function getType(): string;
    public function getCreatedAt(): \DateTimeImmutable;
    public function isUnread(): bool;
    public function getReadAt(): \DateTimeImmutable;
    public function getParameters(): array;
    public function getSender(): ?CustomerInterface;
    public function getRecipient(): AdminUserInterface;
    public function getClickAction(): ClickAction;
    public function seen(\DateTimeImmutable $readAt = null): void;
    public function setRecipient(AdminUserInterface $recipient): void;
}
