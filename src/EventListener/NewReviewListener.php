<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Command\Notification\CreateNotification\CreateNotificationCommand;
use App\Model\NewReviewNotification;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductReview;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Messenger\MessageBusInterface;

final class NewReviewListener
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function addNotification(GenericEvent $event): void
    {
        /** @var ProductReview $subject */
        $subject = $event->getSubject();
        /** @var  ProductInterface $reviewSubject */
        $reviewSubject = $subject->getReviewSubject();
        $this->commandBus->dispatch(
            new CreateNotificationCommand(
                NewReviewNotification::NOTIFICATION_TYPE,
                null,
                'sylius_admin_product_review_update',
                ['id' => $subject->getId()],
                [
                    'author' => $subject->getAuthor()->getEmail(),
                    'comment' => $subject->getComment(),
                    'title' => $subject->getTitle(),
                    'product' => $reviewSubject->getName(),
                    'created_at' => $subject->getCreatedAt(),
                    'rating' => $subject->getRating()
                ]
            )
        );
    }

}
