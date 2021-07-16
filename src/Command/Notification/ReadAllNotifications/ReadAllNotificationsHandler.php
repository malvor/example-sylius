<?php

declare(strict_types=1);

namespace App\Command\Notification\ReadAllNotifications;

use App\Repository\NotificationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ReadAllNotificationsHandler implements MessageHandlerInterface
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

    public function __invoke(ReadAllNotificationsCommand $command): void
    {
        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->find($command->getUserId());
        $notifications = $this->notificationRepository->findByRecipient($user);

        foreach ($notifications as $notification) {
            $notification->seen();
        }
        $this->entityManager->flush();
    }
}
