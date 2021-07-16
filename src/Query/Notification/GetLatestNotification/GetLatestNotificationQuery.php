<?php

declare(strict_types=1);

namespace App\Query\Notification\GetLatestNotification;

final class GetLatestNotificationQuery
{
    /** @var int */
    private $userId;
    /** @var int */
    private $lastRetrieve;

    public function __construct(int $userId, int $lastRetrieve)
    {
        $this->userId = $userId;
        $this->lastRetrieve = $lastRetrieve;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLastRetrieve(): int
    {
        return $this->lastRetrieve;
    }
}
