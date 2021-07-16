<?php

declare(strict_types=1);

namespace App\Query\Notification\FindLastMessages;

final class FindLastMessagesQuery
{
    private $userId;
    private $limit;
    private $offset;

    public function __construct($userId, $limit, $offset)
    {
        $this->userId = $userId;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
