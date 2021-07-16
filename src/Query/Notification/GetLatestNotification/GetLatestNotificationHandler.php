<?php

declare(strict_types=1);

namespace App\Query\Notification\GetLatestNotification;

use App\Factory\NotificationFactoryInterface;
use App\Model\NotificationInterface as ModelNotification;
use App\Provider\NotificationProviderInterface;
use App\Repository\NotificationRepositoryInterface;
use DateTime;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Routing\RouterInterface;

final class GetLatestNotificationHandler implements MessageHandlerInterface
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


    public function __invoke(GetLatestNotificationQuery $query): array
    {
        $since = new DateTime('@' . $query->getLastRetrieve());
        $since->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->find($query->getUserId());

        return $this->notificationProvider->provideToSerialize(
            $this->notificationRepository->findUserNotificationsFrom($user, $since)
        );
    }

}
