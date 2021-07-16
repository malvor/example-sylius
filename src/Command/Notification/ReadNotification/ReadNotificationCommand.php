<?php

declare(strict_types=1);

namespace App\Command\Notification\ReadNotification;

final class ReadNotificationCommand
{
    private $userId;
    private $notificationId;

    public function __construct($userId, $notificationId)
    {
        $this->userId = $userId;
        $this->notificationId = $notificationId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getNotificationId()
    {
        return $this->notificationId;
    }
}
