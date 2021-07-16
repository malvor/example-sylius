<?php

declare(strict_types=1);


namespace App\Context;

use App\Entity\Notification\NotificationType;

interface NotificationContextInterface
{
    public function findNotificationType(string $type): NotificationType;
}
