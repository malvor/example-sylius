<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Notification\Notification;
use App\Entity\Notification\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Sylius\Component\Core\Model\AdminUserInterface;

final class NotificationRepository extends EntityRepository implements NotificationRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Notification::class));
    }

    /** {@inheritdoc} */
    public function findUserNotifications(AdminUserInterface $user, int $limit, int $offset): array
    {
        $queryBuilder = $this->createQueryBuilder('notification')
            ->select('notification')
            ->where('notification.recipient = :user')
            ->setParameters([':user' => $user])
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->addOrderBy('notification.createdAt', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function findUserNotificationsFrom(AdminUserInterface $user, \DateTime $from): array
    {
        $queryBuilder = $this->createQueryBuilder('notification')
            ->select('notification')
            ->where('notification.recipient = :user')
            ->andWhere('notification.createdAt > :from')
            ->setParameters([':user' => $user, 'from' => $from])
            ->addOrderBy('notification.createdAt', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function get(int $notificationId): NotificationInterface
    {
        /** @var null|NotificationInterface $notification */
        $notification = $this->find($notificationId);
        if (null === $notification) {
            throw new Exception('Record not found');
        }

        return $notification;
    }

    public function findByRecipient(AdminUserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('notification')
            ->select('notification')
            ->where('notification.recipient = :user')
            ->andWhere('notification.readAt IS NULL')
            ->setParameters([':user' => $user])
            ->addOrderBy('notification.createdAt', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

}
