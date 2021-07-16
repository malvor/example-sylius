<?php

declare(strict_types=1);

namespace App\Command\Notification\ReadAllNotifications;

final class ReadAllNotificationsCommand
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
