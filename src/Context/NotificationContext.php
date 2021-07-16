<?php

declare(strict_types=1);

namespace App\Context;

use App\Entity\Notification\NotificationType;

final class NotificationContext implements NotificationContextInterface
{
    private $notificationTypes;

    public function __construct(array $defaultNotifications)
    {
        $this->loadTypes($defaultNotifications);
    }

    public function findNotificationType(string $type): NotificationType
    {
        $notificationType = $this->notificationTypes[$type] ?? null;
        if (null === $notificationType) {
            throw new \InvalidArgumentException('Missing notification type '. $type);
        }
        return $notificationType;
    }

    public function getNotificationTypes(): array
    {
        return $this->notificationTypes;
    }

    private function loadTypes(array $notificationTypes)
    {
        foreach ($notificationTypes as $type => $typeData) {
            if (false === isset($this->notificationTypes[$type])) {
                if (false === array_key_exists('class', (array)$typeData)) {
                    throw new \InvalidArgumentException(sprintf('Missing %s notification class', $type));
                }
                $this->notificationTypes[$type] = new NotificationType($type, $typeData['class'], $typeData['translation'] ?? null);
            }
        }
    }
}
