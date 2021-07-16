<?php

declare(strict_types=1);

namespace App\Command\Notification\CreateNotification;

use App\Entity\Notification\Notification as NotificationEntity;
use App\Entity\Notification\ClickAction;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateNotificationHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RepositoryInterface */
    private $adminUserRepository;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RepositoryInterface $adminUserRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->adminUserRepository = $adminUserRepository;
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(CreateNotificationCommand $command): void
    {
        $admins = $this->adminUserRepository->findAll();
        /** @var AdminUserInterface $admin */
        foreach ($admins as $admin) {
            $entity = new NotificationEntity(
                $command->getType(),
                new ClickAction($command->getClickActionRoute(), $command->getClickActionParameters()),
                $command->getParameters(),
                $admin,
                $command->getSenderId() !== null ?$this->customerRepository->find($command->getSenderId()) : null
            );
            $this->entityManager->persist($entity);

        }
        $this->entityManager->flush();
    }
}
