<?php

declare(strict_types=1);

namespace App\Model;

final class NewReviewNotification extends DefaultNotification implements NotificationInterface
{
    public const NOTIFICATION_TYPE = 'websnacks.system.new_review';

    use NotificationFromEntityTrait,
        NotificationToArrayTrait;

    public function messageForNotification(NotificationInterface $notification): string
    {
        return '';
    }

    public function messageForNotifications(array $notifications): string
    {
        return '';
    }

    public function getType(): string
    {
        return self::NOTIFICATION_TYPE;
    }
}
