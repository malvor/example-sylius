<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Notification\NotificationInterface;

interface NotificationProviderInterface
{
    /**
     * @param array<NotificationInterface> $notificationsEntities
     * @return mixed
     */
    public function provideToSerialize(array $notificationsEntities): array;
}
