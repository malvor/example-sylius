<?php

declare(strict_types=1);

namespace App\Query\Notification\FindLastMessages;

use App\Provider\NotificationProviderInterface;
use App\Repository\NotificationRepositoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class FindLastMessagesHandler implements MessageHandlerInterface
{
    /** @var NotificationRepositoryInterface */
    private $notificationRepository;

    /** @var RepositoryInterface */
    private $adminUserRepository;

    /** @var NotificationProviderInterface */
    private $notificationProvider;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        RepositoryInterface $adminUserRepository,
        NotificationProviderInterface $notificationProvider
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->adminUserRepository = $adminUserRepository;
        $this->notificationProvider = $notificationProvider;
    }


    public function __invoke(FindLastMessagesQuery $query): array
    {
        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->find($query->getUserId());

        return $this->notificationProvider->provideToSerialize(
            $this->notificationRepository->findUserNotifications(
                $user, $query->getLimit(), $query->getOffset()
            )
        );
    }
}
