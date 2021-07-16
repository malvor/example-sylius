<?php

declare(strict_types=1);

namespace App\Command\Notification\ReadNotification;

use App\Repository\NotificationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ReadNotificationHandler implements MessageHandlerInterface
{
    /** @var RepositoryInterface */
    private $adminUserRepository;

    /** @var NotificationRepositoryInterface */
    private $notificationRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        RepositoryInterface $adminUserRepository,
        NotificationRepositoryInterface $notificationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->notificationRepository = $notificationRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ReadNotificationCommand $query): void
    {
        $user = $this->adminUserRepository->find($query->getUserId());
        $notification = $this->notificationRepository->get($query->getNotificationId());

        if ($notification->getRecipient()->getId() !== $user->getId()) {
            throw new Exception('Forbidden');
        }

        $notification->seen();
        $this->entityManager->flush();
    }
}
