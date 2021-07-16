<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Notification\ClickAction;
use App\Entity\Notification\NotificationInterface as EntityNotification;

trait NotificationFromEntityTrait
{
    public function fromEntity(EntityNotification $notification): void
    {
        $this->id = $notification->getId();
        $this->createdAt = $notification->getCreatedAt();
        $this->unread = $notification->isUnread();
        $this->parameters = $notification->getParameters();
        $clickAction = $notification->getClickAction();
        if ($clickAction->isClickable()) {
            $this->clickAction = new ClickAction($clickAction->getRoute(), $clickAction->getParameters());
        }
    }
}
