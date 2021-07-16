<?php

declare(strict_types=1);


namespace App\Repository;

use App\Entity\Notification\NotificationInterface;
use Sylius\Component\Core\Model\AdminUserInterface;

interface NotificationRepositoryInterface
{
    public function findUserNotifications(AdminUserInterface $user, int $limit, int $offset): array;

    /**
     * @return array<NotificationInterface>
     */
    public function findUserNotificationsFrom(AdminUserInterface $user, \DateTime $from): array;

    public function get(int $notificationId): NotificationInterface;

    /**
     * @param AdminUserInterface $user
     * @return array<NotificationInterface>
     */
    public function findByRecipient(AdminUserInterface $user): array;

    public function count(array $criteria);
}
