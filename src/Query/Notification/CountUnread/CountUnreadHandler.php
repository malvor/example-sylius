<?php

declare(strict_types=1);

namespace App\Query\Notification\CountUnread;

use App\Repository\NotificationRepositoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CountUnreadHandler implements MessageHandlerInterface
{
    /** @var NotificationRepositoryInterface */
    private $notificationRepository;

    /** @var RepositoryInterface */
    private $adminUserRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        RepositoryInterface $adminUserRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->adminUserRepository = $adminUserRepository;
    }

    public function __invoke(CountUnreadQuery $query): int
    {
        /** @var AdminUserInterface $adminUser */
        $user = $this->adminUserRepository->find($query->getUserId());
        return $this->notificationRepository->count(['recipient' => $user->getId(), 'readAt' => null]);
    }
}
