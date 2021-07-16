<?php

declare(strict_types=1);

namespace App\Factory;

use App\Context\NotificationContextInterface;
use App\Entity\Notification\NotificationInterface;
use App\Model\NotificationInterface as ModelNotification;
use Symfony\Contracts\Translation\TranslatorInterface;


final class NotificationFactory implements NotificationFactoryInterface
{
    /** @var NotificationContextInterface */
    private $notificationContext;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(NotificationContextInterface $notificationContext, TranslatorInterface $translator)
    {
        $this->notificationContext = $notificationContext;
        $this->translator = $translator;
    }

    public function createFromNotificationEntity(NotificationInterface $notificationEntity): ModelNotification
    {
        $notificationType = $this->notificationContext->findNotificationType($notificationEntity->getType());
        /** @var ModelNotification $notification */
        $notification = new $notificationType->class();
        $notification->fromEntity($notificationEntity);
        if (null !== $notificationType->translation) {
            $notification->setMessage(
                $this->translator->trans(
                    $notificationType->translation,
                    $this->preparedParameters($notificationEntity->getParameters())
                )
            );
        }

        return $notification;
    }

    private function preparedParameters(array $parameters): array
    {
        return array_combine(
            array_map(
                function ($key) {
                    return ':' . $key . ':';
                },
                array_keys($parameters)
            ),
            $parameters
        );
    }
}
