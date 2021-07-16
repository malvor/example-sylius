<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Trait NotificationToArrayTraitCustomerInterface
 * @package App\Model
 */
trait NotificationToArrayTrait
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'unread' => $this->isUnread(),
            'type' => $this->getType(),
            'message' => $this->message(),
            'created' => $this->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }
}
