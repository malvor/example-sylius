<?php

declare(strict_types=1);


namespace App\Factory;

use App\Entity\Notification\NotificationInterface;
use App\Model\NotificationInterface as ModelNotification;

interface NotificationFactoryInterface
{
    public function createFromNotificationEntity(NotificationInterface $notificationEntity): ModelNotification;

}
