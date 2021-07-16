<?php

declare(strict_types=1);

namespace App\Provider;

use App\Factory\NotificationFactoryInterface;
use App\Model\NotificationInterface as ModelNotification;
use Symfony\Component\Routing\RouterInterface;

final class NotificationProvider implements NotificationProviderInterface
{
    /** @var NotificationFactoryInterface */
    private $notificationFactory;

    /** @var RouterInterface */
    private $router;

    public function __construct(
        NotificationFactoryInterface $notificationFactory,
        RouterInterface $router
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->router = $router;
    }

    public function provideToSerialize(array $notificationsEntities): array
    {
        $notifications = [];
        foreach ($notificationsEntities as $notification) {
            $notifications[] = $this->notificationFactory->createFromNotificationEntity($notification);
        }

        return array_map(function (ModelNotification $notification) {
            $returnNotification = $notification->toArray();
            $clickAction = $notification->getClickAction();
            if (null !== $clickAction) {
                $returnNotification['click_action'] = $this->router->generate($clickAction->getRoute(), $clickAction->getParameters());
            }
            return $returnNotification;
        }, $notifications);
    }
}
