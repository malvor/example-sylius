<?php

declare(strict_types=1);

namespace App\Controller\Admin\Notification;

use App\Query\Notification\CountUnread\CountUnreadQuery;
use App\Query\Notification\FindLastMessages\FindLastMessagesQuery;
use App\Query\Notification\GetLatestNotification\GetLatestNotificationQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class NotificationList
{
    /** @var MessageBusInterface */
    private $messageBus;
    /** @var null|TokenStorageInterface */
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
        if (null === $this->token || null === $this->token->getToken()) {
            return new JsonResponse(['message' => 'Error'], Response::HTTP_FORBIDDEN);
        }

        $limit = (int)$request->get('limit', null);
        $lastRetrieve = (int)$request->get('last_refresh', null);
        $offset = (int)$request->get('offset', null);


        if (0 === $lastRetrieve) {
            $envelope = $this->messageBus->dispatch(
                new FindLastMessagesQuery(
                    $this->token->getToken()->getUser()->getId(),
                    $limit,
                    $offset

                )
            );
        } else {
            $envelope = $this->messageBus->dispatch(
                new GetLatestNotificationQuery(
                    $this->token->getToken()->getUser()->getId(),
                    $lastRetrieve
                )
            );
        }

        $unreadEnvelope = $this->messageBus->dispatch(
            new CountUnreadQuery(
                $this->token->getToken()->getUser()->getId(),
            )
        );

        return new JsonResponse(
            [
                'status' => 'success',
                'data' => [
                    'last_refresh' => time(),
                    'unread' => ($unreadEnvelope->last(HandledStamp::class)->getResult()),
                    'notifications' => ($envelope->last(HandledStamp::class)->getResult())
                ]
            ]
        );
    }
}
