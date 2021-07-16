<?php

declare(strict_types=1);

namespace App\Controller\Admin\Notification;

use App\Command\Notification\ReadAllNotifications\ReadAllNotificationsCommand;
use App\Command\Notification\ReadNotification\ReadNotificationCommand;
use App\Query\Notification\CountUnread\CountUnreadQuery;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Throwable;

final class ReadNotification
{
    const MARK_ALL = 'all';

    /** @var MessageBusInterface */
    private $messageBus;

    /** @var TokenStorageInterface */
    private $token;

    public function __construct(
        MessageBusInterface $messageBus,
        TokenStorageInterface $token
    ) {
        $this->messageBus = $messageBus;
        $this->token = $token;
    }

    public function __invoke(Request $request): Response
    {
        $notificationId = $request->get('notification_id', 0);

        if (null === $this->token || null === $this->token->getToken()) {
            return new JsonResponse(['message' => 'Error'], Response::HTTP_FORBIDDEN);
        }
        try {
            if (self::MARK_ALL === $notificationId) {
                $this->messageBus->dispatch(
                    new ReadAllNotificationsCommand(
                        $this->token->getToken()->getUser()->getId()
                    )
                );
            } else {
                $this->messageBus->dispatch(
                    new ReadNotificationCommand(
                        $this->token->getToken()->getUser()->getId(),
                        (int)$notificationId
                    )
                );
            }
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 404
            );
        } catch (Throwable $exception) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 400
            );
        }
        $envelope = $this->messageBus->dispatch(
            new CountUnreadQuery(
                $this->token->getToken()->getUser()->getId(),
            )
        );

        return new JsonResponse(
            [
                'status' => 'success',
                'data' => [
                    'unread' => ($envelope->last(HandledStamp::class)->getResult())
                ]
            ]
        );
    }

}
